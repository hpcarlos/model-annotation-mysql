<?php

namespace fjf2002\ModelAnnotation;

use Illuminate\Console\Command;
use ReflectionClass;


class AnnotateCommand extends Command {
    protected $name = 'annotate:models';

    protected $description = 'annotate models';

    public function __construct() {
        parent::__construct();
    }

    private static function loadAllClasses() {
        $app = app();
        foreach (array_merge(glob("{$app->path}/Models/*.php"),glob("{$app->path}/Models/**/*.php"),glob("{$app->path}/Models/**/**/*.php")) as $classFileName) {
            /*
             * Put require_once statement into function body to limit too strange effects
             * (i. e. definition of global variables etc.):
             */
            (function(string $classFileName) {
                require_once($classFileName);
            }) ($classFileName);
        }
    }

    public function handle() {
      self::loadAllClasses();

      collect(get_declared_classes())->filter(function ($item) {
        return substr($item, 0, 4) === 'App\\'
          && is_subclass_of($item, '\Illuminate\Database\Eloquent\Model');
      })->each(function($className) {
        Annotation::annotateModel(new ReflectionClass($className));
      });
    }

    protected function getArguments() {
        return [];
    }

    protected function getOptions() {
        return [];
    }
}
