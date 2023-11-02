@setup
  $ssh = getenv('LP_SSH_CMD');
@endsetup

@servers(['web' => $ssh, 'localhost' => '127.0.0.1'])

@story('pull-db')
  dump
  getdb
  cleandb
@endstory

@story('pull-all-files')
  backupapplication
  getfiles
  cleanfiles
@endstory

@story('pull-only-files')
  backupfilesfolder
  getfiles
  cleanfiles
@endstory

@story('pull')
  dump
  getdb
  cleandb
  backupallfiles
  getfiles
  cleanfiles
@endstory

@task('dump', ['on' => 'web'])
  mysqldump -u {{ getenv('LP_DB_USER') }} -p"{{ getenv('LP_DB_PWD') }}" {{ getenv('LP_DB') }} > {{ getenv('LP_DB_BACK_PATH') }}
@endtask

@task('getdb', ['on' => 'localhost'])
  scp {{ getenv('LP_SSH_CMD') }}:{{ getenv('LP_DB_BACK_PATH') }} /app/db.sql
@endtask

@task('cleandb', ['on' => 'web'])
  rm {{ getenv('LP_DB_BACK_PATH') }}
@endtask

@task('backupallfiles', ['on' => 'web'])
  cd {{ getenv('LP_SITE_ROOT') }}
  tar czf {{ getenv('LP_FILES_BACK_PATH') }} --exclude "application/files/cache" --exclude "application/files/tmp"  --exclude "application/config/database.php" application/ concrete/ packages/ composer.json composer.lock index.php
@endtask

@task('getfiles', ['on' => 'localhost'])
  scp {{ getenv('LP_SSH_CMD') }}:{{ getenv('LP_FILES_BACK_PATH') }} /app/f.tar.gz
@endtask

@task('cleanfiles', ['on' => 'web'])
  rm {{ getenv('LP_FILES_BACK_PATH') }}
@endtask

@task('backupapplication', ['on' => 'web'])
  cd {{ getenv('LP_SITE_ROOT') }}
  tar czf {{ getenv('LP_FILES_BACK_PATH') }} --exclude "application/files/cache"  --exclude "application/config/database.php" application/
@endtask

@task('backupfilesfolder', ['on' => 'web'])
  cd {{ getenv('LP_SITE_ROOT') }}
  cd application/
  tar czf {{ getenv('LP_FILES_BACK_PATH') }} --exclude "files/cache" files/
@endtask