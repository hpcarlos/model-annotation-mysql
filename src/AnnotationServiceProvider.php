<?php

namespace fjf2002\ModelAnnotation;

use Illuminate\Support\ServiceProvider;

class AnnotationServiceProvider extends ServiceProvider {
    protected $commands = [
        AnnotateCommand::class
    ];

    public function register() {
        $this->commands($this->commands);
    }
}
