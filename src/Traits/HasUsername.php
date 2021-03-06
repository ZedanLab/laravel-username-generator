<?php

namespace ZedanLab\UsernameGenerator\Traits;

use Illuminate\Database\Eloquent\Model;
use ZedanLab\UsernameGenerator\Observers\UsernameGeneratorObserver;
use ZedanLab\UsernameGenerator\Services\UsernameGeneratorOptions;

trait HasUsername
{
    /**
     * The Username Generator options for model.
     *
     * @var array
     */
    protected static $usernameGeneratorOptions = [];

    /**
     * Boot Eloquent HasUsername trait for the model.
     *
     * @return void
     */
    public static function bootHasUsername()
    {
        static::setDefaultUsernameGeneratorOptions();

        static::observe(app(UsernameGeneratorObserver::class));
    }

    /**
     * Setup the Username Generator default options.
     *
     * @return array
     */
    public static function defaultUsernameGeneratorOptions(): array
    {
        return [];
    }

    /**
     * Set the Username Generator default options.
     *
     * @return void
     */
    public static function setDefaultUsernameGeneratorOptions(): void
    {
        if (! blank(static::$usernameGeneratorOptions)) {
            return;
        }

        static::setUsernameGeneratorOptions(static::defaultUsernameGeneratorOptions(), true);
    }

    /**
     * Set the Username Generator options.
     *
     * @param  array   $options
     * @param  bool    $isDefault
     * @return array
     */
    public static function setUsernameGeneratorOptions(array $options, bool $isDefault = false): array
    {
        if (! $isDefault) {
            static::setDefaultUsernameGeneratorOptions();
        }

        static::$usernameGeneratorOptions = array_merge(static::$usernameGeneratorOptions, $options);

        return static::$usernameGeneratorOptions;
    }

    /**
     * Get the Username Generator options.
     *
     * @return array
     */
    public static function usernameGeneratorOptions(): array
    {
        return static::$usernameGeneratorOptions;
    }

    /**
     * Get model' username.
     *
     * @return string|null
     */
    public function getUsername(): string | null
    {
        $field = UsernameGeneratorOptions::get('field', $this);

        $username = $this->getRawOriginal($field);

        return $username;
    }

    /**
     * Find a model by its username.
     *
     * @param  string                                     $username
     * @param  array                                      $columns
     * @return \Illuminate\Database\Eloquent\Model|null
     */
    public static function findByUsername(string $username, array $columns = ['*']): Model | null
    {
        return static::whereUsername($username)->first($columns);
    }

    /**
     * Find a model by its primary key or throw an exception.
     *
     * @param  string                                                 $username
     * @param  array                                                  $columns
     * @throws \Illuminate\Database\Eloquent\ModelNotFoundException
     * @return \Illuminate\Database\Eloquent\Model
     */
    public static function findByUsernameOrFail(string $username, array $columns = ['*']): Model
    {
        return static::whereUsername($username)->firstOrFail($columns);
    }

    /**
     * Scope a query to only include like the given coordinates.
     *
     * @param  \Illuminate\Database\Eloquent\Builder   $query
     * @return \Illuminate\Database\Eloquent\Builder
     */
    public function scopeWhereUsername($query, string $username)
    {
        $field = UsernameGeneratorOptions::get('field', new static());

        return $query->where($field, $username);
    }

    /**
     * Scope a query to only include like the given coordinates.
     *
     * @param  \Illuminate\Database\Eloquent\Builder   $query
     * @return \Illuminate\Database\Eloquent\Builder
     */
    public function scopeWhereUsernameLike($query, string $username)
    {
        $field = UsernameGeneratorOptions::get('field', new static());

        return $query->where($field, 'like', "%$username");
    }

    /**
     * Find a model by its primary key or throw an exception.
     *
     * @param  string                                                 $username
     * @param  \Illuminate\Database\Eloquent\Model|string|int         $modelId
     * @throws \Illuminate\Database\Eloquent\ModelNotFoundException
     * @return bool
     */
    public static function isUsernameUnique(string $username, Model | string | int $modelId = null): bool
    {
        $query = static::whereUsername($username);

        if (! blank($modelId)) {
            $model = new static();

            if ($modelId instanceof Model) {
                $model = $modelId;
                $modelId = $model->{$model->getRouteKeyName()};
            }

            $query->whereNot($model->getRouteKeyName(), $modelId);
        }

        return $query->exists() === false;
    }

    /**
     * Retrieve the model for a bound value.
     *
     * @param  mixed                                      $value
     * @param  string|null                                $field
     * @return \Illuminate\Database\Eloquent\Model|null
     */
    public function resolveRouteBinding($value, $field = null)
    {
        if (UsernameGeneratorOptions::get('route_binding', $this)) {
            $field = UsernameGeneratorOptions::get('field', new static());
        }

        return parent::resolveRouteBinding($value, $field);
    }
}
