set :stage, :production
set :branch, ENV['REVISION'] || ENV['BRANCH_NAME'] || 'master'
set :linked_dirs, %w{themes/manifold-marketing/content themes/manifold-marketing/meta storage/framework/sessions storage/logs storage/docs storage/app/media storage/app/uploads}
set :linked_files, %w{.env .warewolf/config www/robots.txt}
server 'manifoldapp.org', user: 'manifold_marketing', roles: %w(app db web)
