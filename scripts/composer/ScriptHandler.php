<?php

/**
 * @file
 * Contains \DrupalProject\composer\ScriptHandler.
 */

namespace DrupalProject\composer;

use Composer\Script\Event;
use Symfony\Component\Filesystem\Filesystem;
use Symfony\Component\Finder\Finder;

class ScriptHandler
{

  protected static function getDrupalRoot($project_root)
  {
    return $project_root .  '/web';
  }

  public static function createRequiredFiles(Event $event)
  {
    $fs = new Filesystem();
    $root = static::getDrupalRoot(getcwd());

    $dirs = [
      'modules',
      'profiles',
      'themes',
    ];

    // Required for unit testing
    foreach ($dirs as $dir) {
      if (!$fs->exists($root . '/'. $dir)) {
        $fs->mkdir($root . '/'. $dir);
        $fs->touch($root . '/'. $dir . '/.gitkeep');
      }
    }

    // Create the files directory with chmod 0777
    if (!$fs->exists($root . '/sites/default/files')) {
      $oldmask = umask(0);
      $fs->mkdir($root . '/sites/default/files', 0777);
      umask($oldmask);
      $event->getIO()->write("Create a sites/default/files directory with chmod 0777");
    }
  }

  // This is called by the QuickSilver deploy hook to convert from
  // a 'lean' repository to a 'fat' repository. This should only be
  // called when using this repository as a custom upstream, and
  // updating it with `terminus composer <site>.<env> update`. This
  // is not used in the GitHub PR workflow.
  public static function prepareForPantheon()
  {
    // Get rid of any .git directories that Composer may have added.
    // n.b. Ideally, there are none of these, as removing them may
    // impair Composer's ability to update them later. However, leaving
    // them in place prevents us from pushing to Pantheon.
    $dirsToDelete = [];
    $finder = new Finder();
    foreach (
      $finder
        ->directories()
        ->in(getcwd())
        ->ignoreDotFiles(false)
        ->ignoreVCS(false)
        ->depth('> 0')
        ->name('.git')
      as $dir) {
      $dirsToDelete[] = $dir;
    }
    $fs = new Filesystem();
    $fs->remove($dirsToDelete);

    // Fix up .gitignore: remove everything above the "::: cut :::" line
    $gitignoreFile = getcwd() . '/.gitignore';
    $gitignoreContents = file_get_contents($gitignoreFile);
    $gitignoreContents = preg_replace('/.*::: cut :::*/s', '', $gitignoreContents);
    file_put_contents($gitignoreFile, $gitignoreContents);
  }
  
  // Git add -A && git commit -m"..." && git push ... 
  public static function dolebasAmPush(Event $event=NULL) {
    
    $myArr = $event->getArguments();
    $myVar = $myArr[0];
    
    // If it does not apply to dolebas_subtheme
    if ($myVar != 'dolebas_subtheme') {
      system('cd ~/workspace/web/modules/custom/' . $myVar . ' && DOLEBAS_MODULE="${PWD##*/}" && origin="git@github.com:jhammars/${DOLEBAS_MODULE}.git" && git remote rm origin && git remote add origin $origin && git add -A && git commit -m"Ref comment in pull request" && git fetch composer && git rebase composer/master && git push --force origin');

    // Otherwise, apply to dolebas_subtheme
    } else {
      system('cd ~/workspace/web/themes/custom/' . $myVar . ' && DOLEBAS_MODULE="${PWD##*/}" && origin="git@github.com:jhammars/${DOLEBAS_MODULE}.git" && git remote rm origin && git remote add origin $origin && git add -A && git commit -m"Ref comment in pull request" && git fetch composer && git rebase composer/master && git push --force origin');
    }
  }  
  
  // Git status for several modules
  public static function dolebasGitStatus() {
    system('echo DOLEBAS_CONFIG && cd ~/workspace/web/modules/custom/dolebas_config/ && git branch -u composer/master && git fetch composer && git rebase composer/master && git status && echo DOLEBAS_DEFAULT_CONTENT && cd ~/workspace/web/modules/custom/dolebas_default_content/ && git branch -u composer/master && git fetch composer && git rebase composer/master && git status && echo DOLEBAS_PAYMENTS && cd ~/workspace/web/modules/custom/dolebas_payments/ && git branch -u composer/master && git fetch composer && git rebase composer/master && git status && echo DOLEBAS_PLAYER && cd ~/workspace/web/modules/custom/dolebas_player/ && git branch -u composer/master && git fetch composer && git rebase composer/master && git status && echo DOLEBAS_PUBLISHER && cd ~/workspace/web/modules/custom/dolebas_publisher/ && git branch -u composer/master && git fetch composer && git rebase composer/master && git status && echo DOLEBAS_UPLOADER && cd ~/workspace/web/modules/custom/dolebas_uploader/ && git branch -u composer/master && git fetch composer && git rebase composer/master && git status && echo DOLEBAS_USER && cd ~/workspace/web/modules/custom/dolebas_user/ && git branch -u composer/master && git fetch composer && git rebase composer/master && git status && echo DOLEBAS_SUBTHEME && cd ~/workspace/web/themes/custom/dolebas_subtheme/ && git branch -u composer/master && git fetch composer && git rebase composer/master && git status && cd ~/workspace');
  }  
  
}
