<?php

namespace Palamike\VueDash\Console\Commands;

use Illuminate\Console\Command;

class MakeModule extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'make:module
                            { parent : the top level module in Plural CamelCase } 
                            { module : the module name in Plural CamelCase } 
                            {--debug : debug flag}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Make PMF Module. Parent and module always plural and capitalize ';

    /**
     * Create a new command instance.
     *
     * @return void
     */
    public function __construct()
    {
        parent::__construct();
    }

    /**
     * Execute the console command.
     *
     * @return mixed
     */
    public function handle()
    {
    	$debug = $this->option('debug');
    	// example Users
	    $parent = $this->argument('parent');

	    //example Roles
	    $module = $this->argument('module');

	    //example Role
	    $singular = str_singular($module);

	    $singularLower = lcfirst($singular);

	    $pluralLower = lcfirst($module);

	    $pluralSnake = snake_case($module);

	    $singularSnake = snake_case($singular);

	    $parentSnake = snake_case($parent);

	    $parentKebab = kebab_case($parent);

		$pluralKebab = kebab_case($module);

	    $vars = [
	    	'parentPlural' => $parent,
		    'parentPluralSnake' => $parentSnake,
		    'parentPluralKebab' => $parentKebab,
		    'modulePlural' => $module,
		    'moduleSingular' => $singular,
		    'moduleSingularLower' => $singularLower,
		    'modulePluralLower' => $pluralLower,
		    'moduleSingularSnake' => $singularSnake,
		    'modulePluralSnake' => $pluralSnake,
		    'modulePluralKebab' => $pluralKebab,
		    'moduleSingularKebab' => kebab_case($singular)
	    ];

	    $paths = [
		    'controllerPath' => app_path('Http/Controllers/Modules/'.$vars['parentPlural'].'/'),
		    'controllerFile' => $vars['moduleSingular'].'Controller.php',
		    'modelPath' => app_path('Models/'),
		    'modelFile' => $vars['moduleSingular'].'.php',
		    'viewPath' => resource_path('views/modules/'.$vars['parentPluralSnake'].'/'),
		    'viewFile' => $vars['modulePluralSnake'].'.blade.php',
		    'entryPath' => resource_path('assets/js/entries/modules/'.$vars['parentPluralSnake'].'/'),
		    'entryFile' => $vars['modulePluralSnake'].'.js',
		    'componentPath' => resource_path('assets/js/components/modules/'.$vars['parentPluralSnake'].'/'),
		    'componentFile' => $vars['moduleSingular'].'Module.vue',
		    'langFile' => resource_path('assets/js/lang/th.js'),
		    'routeFile' => base_path('routes/web.php'),
		    'mixFile' => base_path('webpack.mix.js')
	    ];

	    if ($debug) {
		    $this->info('vars = '.var_export($vars, true));
		    $this->info('paths = '.var_export($paths, true));
	    }



	    $this->generateController($paths, $vars);
	    $this->generateModel($paths, $vars);
	    $this->generateView($paths, $vars);
	    $this->generateEntry($paths, $vars);
	    $this->generateComponent($paths, $vars);
	    $this->generateLang($paths, $vars);
	    $this->generateRoute($paths, $vars);
	    $this->generateMix($paths, $vars);

	    return true;

    }

    public function generateController($paths, $vars) {

    	$path = $paths['controllerPath'];
	    $file = $paths['controllerFile'];
	    $fullPath = $path.$file;

    	if (file_exists($fullPath) && ! $this->confirm('Controller already exists !! replace ?')) {
		    $this->info('skip generate file ... '.var_export($file, true));
    		return;
	    }

	    if(!file_exists($path)){
    		mkdir($path);
		    $this->info('created dir ... '.var_export($path, true));
	    }

    	$content = view('generator.module.controller',$vars)->render();
    	$content = '<?php'."\n\n".$content;

    	file_put_contents($fullPath,$content);

	    $this->info('generated controller in path... '.var_export($fullPath, true));
    }

    public function generateModel($paths, $vars) {
	    $path = $paths['modelPath'];
	    $file = $paths['modelFile'];
	    $fullPath = $path.$file;

	    if (file_exists($fullPath) && ! $this->confirm('Model already exists !! replace ?')) {
		    $this->info('skip generate file ... '.var_export($file, true));
		    return;
	    }

	    $content = view('generator.module.model',$vars)->render();
	    $content = '<?php'."\n\n".$content;

	    file_put_contents($fullPath,$content);

	    $this->info('generated model in path... '.var_export($fullPath, true));
    }

	public function generateView($paths, $vars) {
		$path = $paths['viewPath'];
		$file = $paths['viewFile'];
		$fullPath = $path.$file;

		if (file_exists($fullPath) && ! $this->confirm('View already exists !! replace ?')) {
			$this->info('skip generate file ... '.var_export($file, true));
			return;
		}

		if(!file_exists($path)){
			mkdir($path);
			$this->info('created dir ... '.var_export($path, true));
		}

		$content = view('generator.module.view',$vars)->render();

		$content = str_replace('#','@', $content);
		$content = str_replace('[[','{{', $content);
		$content = str_replace(']]','}}', $content);

		file_put_contents($fullPath,$content);

		$this->info('generated model in path... '.var_export($fullPath, true));
	}

	public function generateEntry($paths, $vars) {
		$path = $paths['entryPath'];
		$file = $paths['entryFile'];
		$fullPath = $path.$file;

		if (file_exists($fullPath) && ! $this->confirm('JS Entry already exists !! replace ?')) {
			$this->info('skip generate file ... '.var_export($file, true));
			return;
		}

		if(!file_exists($path)){
			mkdir($path);
			$this->info('created dir ... '.var_export($path, true));
		}

		$content = view('generator.module.entry',$vars)->render();

		file_put_contents($fullPath,$content);

		$this->info('generated js entry in path... '.var_export($fullPath, true));
	}

	public function generateComponent($paths, $vars) {
		$path = $paths['componentPath'];
		$file = $paths['componentFile'];
		$fullPath = $path.$file;

		if (file_exists($fullPath) && ! $this->confirm('Vue Component already exists !! replace ?')) {
			$this->info('skip generate file ... '.var_export($file, true));
			return;
		}

		if(!file_exists($path)){
			mkdir($path);
			$this->info('created dir ... '.var_export($path, true));
		}

		$content = view('generator.module.component',$vars)->render();

		$content = str_replace('##moduleSingularSnake##', $vars['moduleSingularSnake'], $content );



		file_put_contents($fullPath,$content);

		$this->info('generated Vue component in path... '.var_export($fullPath, true));
	}

	public function generateLang($paths, $vars) {

    	if(! $this->confirm('Generate Language in js file ?')) {
    		return;
	    }

		$fullPath = $paths['langFile'];
		$fullPathBackup = $fullPath.'.bak-'.date('Ymd');

		$replacer = '/**LANG_REPLACER**/';

		copy($fullPath,$fullPathBackup);

		$content = file_get_contents($fullPath);

		$content = str_replace($replacer, view('generator.module.js_lang', $vars), $content);

		file_put_contents($fullPath, $content);

		$this->info('generated Lang in file... '.var_export($fullPath, true));
	}

	public function generateRoute($paths, $vars) {

		if(! $this->confirm('Generate Route ?')) {
			return;
		}

		$fullPath = $paths['routeFile'];
		$fullPathBackup = $fullPath.'.bak-'.date('Ymd');

		$replacer = '/**ROUTE_REPLACER**/';

		copy($fullPath,$fullPathBackup);

		$content = file_get_contents($fullPath);

		$content = str_replace($replacer, view('generator.module.route', $vars), $content);

		file_put_contents($fullPath, $content);

		$this->info('generated Route in file... '.var_export($fullPath, true));
	}

	public function generateMix($paths, $vars) {

    	if(! $this->confirm('Generate Mix Entry ?')) {
			return;
		}

		$fullPath = $paths['mixFile'];
		$fullPathBackup = $fullPath.'.bak-'.date('Ymd');

		$replacer = '/**MIX_REPLACER**/';

		copy($fullPath,$fullPathBackup);

		$content = file_get_contents($fullPath);

		$content = str_replace($replacer, view('generator.module.mix', $vars), $content);

		file_put_contents($fullPath, $content);

		$this->info('generated Mix Entry in file... '.var_export($fullPath, true));
	}
}
