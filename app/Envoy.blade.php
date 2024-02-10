@servers(['web' => 'samuel-juanola@13.39.150.46'])

@story('deploy')
    update-depandencies
    update-db
    optimize
@endstory

@task('update-depandencies', ['on' => 'web'])
    cd samuel-juanola.dhonnabhain.me/app
    composer install 
    npm install
    npm run build
@endtask

@task('update-db', ['on' => 'web'])
    cd samuel-juanola.dhonnabhain.me/app
    php artisan migrate --force
@endtask

@task('optimize', ['on' => 'web'])
    cd samuel-juanola.dhonnabhain.me/app
    composer install --optimize-autoloader --no-dev
    php artisan optimize
@endtask