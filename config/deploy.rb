# config valid only for current version of Capistrano
lock "3.9.1"

set :application, "manifold_marketing"
set :repo_url, "git@github.com:castiron/manifold-marketing.git"

set :deploy_to, -> { "/home/#{fetch(:application)}/deploy" }
set :log_level, :info

namespace :deploy do
  desc 'Restart php7.0-fpm service'
  task :restart do
    on roles(:app) do
      execute :sudo, :systemctl, :restart, 'php7.0-fpm'
    end
  end

  desc 'Clear the October CMS application cache'
  task :clear_cache do
    on roles(:app) do
      within current_path do
        execute :php, :artisan, 'cache:clear'
      end
    end
  end

  desc 'Run composer install'
  task :composer_install do
    on roles(:app) do
      within release_path do
        execute :composer, :install, '-o'
      end
    end
  end

  desc 'Run artisan october:up'
  task :october_up do
    on roles(:app) do
      within current_path do
        execute :php, :artisan, 'october:up'
      end
    end
  end

  desc 'Build assets'
  task :build_assets do
    on roles(:app) do
      with path: '/usr/local/node/node-default/bin:node_modules/.bin:$PATH' do
        within release_path do
          execute :yarn, :install ,'--production'
          execute :yarn, :build, '--bail'
        end
      end
    end
  end
end

# Update dependencies
before 'deploy:publishing', 'deploy:composer_install'

# Build Assets
before 'deploy:publishing', 'deploy:build_assets'

# Run migrations
after 'deploy:publishing', 'deploy:october_up'

# Restart PHP (to clear opcaches)
after 'deploy:publishing', 'deploy:restart'

namespace :test do
  desc 'Run unit tests'
  task :unit_tests do
    on roles(:app) do
      with path: 'vendor/bin:/usr/local/node/node-default/bin:node_modules/.bin:$PATH', october_db_connection: :testing do
        within release_path do
          execute :php, :artisan, 'october:up'
          execute :phpunit
        end
      end
    end
  end

  task :default => 'test:unit_tests'
end

task :test => 'test:default'

namespace :info do
  task :new_commits do
    on roles(:app) do
      comparator = 'origin/master'
      app = fetch(:application_root)
      current = capture "cd #{app}/repo && git rev-parse HEAD"
      command = "git show-branch #{current} #{comparator}"
      puts "\nREMOTE is currently at #{current}"
      puts "#{command}\n\n"
      system command
    end
  end

  task :default => 'info:new_commits'
end

task :info => 'info:default'
