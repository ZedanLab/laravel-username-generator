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
     * Set the Username Generator options.
     *
     * @param  array   $options
     * @return array
     */
    public static function setUsernameGeneratorOptions(array $options): array;

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
     * Retrieve the model for a bound value.
     *
     * @param  mixed                                      $value
     * @param  string|null                                $field
     * @return \Illuminate\Database\Eloquent\Model|null
     */
    public function resolveRouteBinding($value, $field = null);
}
