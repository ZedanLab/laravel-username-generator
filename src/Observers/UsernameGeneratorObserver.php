<?php

namespace ZedanLab\UsernameGenerator\Observers;

use Illuminate\Database\Eloquent\Model;
use ZedanLab\UsernameGenerator\UsernameGenerator;

class UsernameGeneratorObserver
{
    /**
     * @var \ZedanLab\UsernameGenerator\UsernameGenerator
     */
    protected $service;

    /**
     * @param \ZedanLab\UsernameGenerator\UsernameGenerator $service
     */
    public function __construct(UsernameGenerator $service)
    {
        $this->service = $service;
    }

    /**
     * Handle the model "creating" event.
     *
     * @param  \Illuminate\Database\Eloquent\Model $model
     * @return void
     */
    public function creating(Model $model)
    {
        $this->service->generateFor($model, 'on_creating');
    }

    /**
     * Handle the model "updating" event.
     *
     * @param  \Illuminate\Database\Eloquent\Model $model
     * @return void
     */
    public function updating(Model $model)
    {
        $this->service->generateFor($model, 'on_updating');
    }
}
