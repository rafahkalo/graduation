<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Illuminate\Support\Facades\File;

class GenerateModelWithService extends Command
{
    protected $signature = 'make:model-with-service {name}';

    protected $description = 'Create a new model, its corresponding service, repository, controller, request, and migration';

    public function handle()
    {
        $name = $this->argument('name');
        $modelPath = app_path("{$name}.php");
        $servicePath = app_path("Services/{$name}Service.php");
        $repositoryPath = app_path("Repositories/{$name}Repo.php");
        $controllerPath = app_path("Http/Controllers/{$name}Controller.php");
        $requestPath = app_path("Http/Requests/{$name}Request.php");

        // إنشاء الموديل مع الميغراشن
        $this->info("Creating model and migration: {$name}");
        $this->call('make:model', ['name' => $name, '--migration' => true]);
        $this->info("Model and migration created: {$modelPath}");

        // إنشاء فولدر Services إذا لم يكن موجودًا
        if (!File::exists(app_path('Services'))) {
            File::makeDirectory(app_path('Services'));
        }

        // إنشاء كلاس السيرفيس
        if (!File::exists($servicePath)) {
            File::put($servicePath, $this->getServiceTemplate($name));
            $this->info("Service class created at: {$servicePath}");
        } else {
            $this->error("Service class already exists: {$servicePath}");
        }

        // إنشاء كلاس الريبو
        if (!File::exists($repositoryPath)) {
            File::put($repositoryPath, $this->getRepositoryTemplate($name));
            $this->info("Repository class created at: {$repositoryPath}");
        } else {
            $this->error("Repository class already exists: {$repositoryPath}");
        }

        // إنشاء كلاس الكونترولر
        if (!File::exists($controllerPath)) {
            File::put($controllerPath, $this->getControllerTemplate($name));
            $this->info("Controller class created at: {$controllerPath}");
        } else {
            $this->error("Controller class already exists: {$controllerPath}");
        }

        // إنشاء فولدر Requests إذا لم يكن موجودًا
        if (!File::exists(app_path('Http/Requests'))) {
            File::makeDirectory(app_path('Http/Requests'));
        }

        // إنشاء كلاس الريكوست
        if (!File::exists($requestPath)) {
            File::put($requestPath, $this->getRequestTemplate($name));
            $this->info("Request class created at: {$requestPath}");
        } else {
            $this->error("Request class already exists: {$requestPath}");
        }

        $this->info('Model, Service, Repository, Controller, Request, and Migration created successfully!');
    }

    private function getServiceTemplate($name)
    {
        return <<<PHP
<?php

namespace App\Services;

class {$name}Service
{
    // Add your service logic here
}
PHP;
    }

    private function getRepositoryTemplate($name)
    {
        return <<<PHP
<?php

namespace App\Repositories;

class {$name}Repo
{
    // Add your repository logic here
}
PHP;
    }

    private function getControllerTemplate($name)
    {
        return <<<PHP
<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class {$name}Controller extends Controller
{
    // Add your controller logic here
}
PHP;
    }

    private function getRequestTemplate($name)
    {
        return <<<PHP
<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class {$name}Request extends FormRequest
{
    public function authorize()
    {
        return true;
    }

    public function rules()
    {
        return [
            // Add your validation rules here
        ];
    }
}
PHP;
    }
}
