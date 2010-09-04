set :stages, %w(dev prod)
set :default_stage, "development"
require 'capistrano/ext/multistage'

set :scm, :git
set :scm_verbose, false
set :repository,  "git@github.com:gabrielpreston/cakefest-contacts.git"
set :deploy_via, :remote_cache
set :use_sudo, false
set :application, 'cakefest-contacts'
set :current_dir, "public"
set :cake_folder, "/home/jose/cake"
set :cake_version, "cakephp1.3"

ssh_options[:username] = 'jose'
ssh_options[:forward_agent] = true

namespace :deploy do
  task :start do
  end

  task :stop do
  end

  task :restart do
  end

  desc <<-DESC
    Symlinks shared configuration and directories into the latest release
    Also clear persistent and model cache and sessions and symlink for usability.
  DESC
  task :finalize_update do
    # Remove the current Cake Core, Plugins Folder, deployed DB/Core configs, and deployed tmp/uploads folder
    run "rm -rf #{deploy_to}/cake #{deploy_to}/plugins #{latest_release}/config/database.php #{latest_release}/config/core.php #{latest_release}/tmp "
    # Move in new copies of the Cake Core and Plugins Folder
    run "cp -rf #{cake_folder}/#{cake_version}/cake #{deploy_to}/cake; cp -rf #{cake_folder}/plugins #{deploy_to}/plugins;"
    # Link the shared DB config, Core Config, TMP Folder, and Uploads Folder
    run "ln -s #{shared_path}/app/config/core.php #{latest_release}/config/core.php; ln -s #{shared_path}/app/config/database.php #{latest_release}/config/database.php; ln -s #{shared_path}/app/tmp #{latest_release}/tmp;"
  end

  task :symlink do
    run "rm -rf #{deploy_to}/#{current_dir} && cp -rf #{latest_release} #{deploy_to}/#{current_dir}"
  end

  task :migrate do
  end

  task :restart do
  end
end

namespace :tail do
  task :default do
    run "tail -f #{deploy_to}/logs/*.log"
  end
end

namespace :startup do
  task :default do
    # Create all the necessary folders
    run "mkdir -p #{deploy_to}/{releases,backup,log,public,private,shared/app/{config,tmp/{cache/{data,models,persistent,views},logs,sessions,tests},webroot/uploads}}"
    # symlink the cake core folder to where we need it
    run "cp -rf #{cake_folder}/#{cake_version}/cake #{deploy_to}/cake"
    run "cp -rf #{cake_folder}/plugins #{deploy_to}/plugins"
    run "mkdir -p #{shared_path}/app/{tmp/{cache/{data,models,persistent,views},sessions,logs,tests}};"
    run "mkdir -p #{shared_path}/app/webroot/uploads"
    # Make the TMP and Uploads folder writeable
    run "chmod -R 777 #{shared_path}/app/tmp #{shared_path}/app/webroot/uploads"
  end
end

namespace :clear_cache do
  task :default do
    # Remove absolutely everything from TMP
    run "#{sudo} rm -rf #{shared_path}/app/tmp/*;"
    # Create TMP folders
    run "mkdir -p #{shared_path}/app/{tmp/{cache/{data,models,persistent,views},sessions,logs,tests}};"
  end
end