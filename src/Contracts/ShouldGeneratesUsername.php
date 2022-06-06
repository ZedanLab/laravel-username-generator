<?php

namespace ZedanLab\UsernameGenerator\Contracts;

use Illuminate\Database\Eloquent\Model;

interface ShouldGeneratesUsername
{
    /**
     * Boot Eloquent HasUsername trait for the model.
     *
     * @return void
     */
    public static function bootHasUsername();

    /**
     * Setup the Username Generator default options.
     *
     * @return array
     */
    public static function defaultUsernameGeneratorOptions(): array;

    /**
     * Set the Username Generator default options.
     *
     * @return void
     */
    public static function setDefaultUsernameGeneratorOptions(): void;

    /**
     * Set the Username Generator options.
     *
     * @param  array   $options
     * @param  bool $isDefault
     * @return array
     */
    public static function setUsernameGeneratorOptions(array $options, bool $isDefault = false): array;

    /**
     * Get the Username Generator options.
     *
     * @return array
     */
    public static function usernameGeneratorOptions(): array;

    /**
     * Get model' username.
     *
     * @return string|null
     */
    public function getUsername(): string | null;

    /**
     * Find a model by its username.
     *
     * @param  string                                     $username
     * @param  array                                      $columns
     * @return \Illuminate\Database\Eloquent\Model|null
     */
    public static function findByUsername(string $username, array $columns = ['*']): Model | null;

    /**
     * Find a model by its primary key or throw an exception.
     *
     * @param  string                                                 $username
     * @param  array                                                  $columns
     * @throws \Illuminate\Database\Eloquent\ModelNotFoundException
     * @return \Illuminate\Database\Eloquent\Model
     */
    public static function findByUsernameOrFail(string $username, array $columns = ['*']): Model;

    /**
     * Scope a query to only include like the given coordinates.
     *
     * @param  \Illuminate\Database\Eloquent\Builder   $query
     * @return \Illuminate\Database\Eloquent\Builder
     */
    public function scopeWhereUsername($query, string $username);

    /**
     * Scope a query to only include like the given coordinates.
     *
     * @param  \Illuminate\Database\Eloquent\Builder   $query
     * @return \Illuminate\Database\Eloquent\Builder
     */
    public function scopeWhereUsernameLike($query, string $username);

    /**
     * Find a model by its primary key or throw an exception.
     *
     * @param  string                                                 $username
     * @param  \Illuminate\Database\Eloquent\Model|string|int         $modelId
     * @throws \Illuminate\Database\Eloquent\ModelNotFoundException
     * @return bool
     */
    public static function isUsernameUnique(string $username, Model | string | int $modelId = null): bool;

    /**
     * Retrieve the model for a bound value.
     *
     * @param  mixed                                      $value
     * @param  string|null                                $field
     * @return \Illuminate\Database\Eloquent\Model|null
     */
    public function resolveRouteBinding($value, $field = null);
}
