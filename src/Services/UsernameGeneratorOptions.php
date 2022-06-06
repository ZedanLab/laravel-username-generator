<?php

namespace ZedanLab\UsernameGenerator\Services;

use Closure;
use Illuminate\Support\Arr;
use InvalidArgumentException;
use Illuminate\Database\Eloquent\Model;
use ZedanLab\UsernameGenerator\Contracts\ShouldGeneratesUsername;

class UsernameGeneratorOptions
{
    /**
     * @var array
     */
    protected $optionsDataType = [
        'source'           => ['string', 'array', Closure::class],
        'field'            => ['string'],
        'route_binding'    => ['boolean'],
        'on_creating'      => ['boolean'],
        'on_updating'      => ['boolean'],
        'unique'           => ['boolean', Closure::class],
        'separator'        => ['string'],
        'lowercase'        => ['boolean'],
        'regex'            => ['null', 'string'],
        'convert_to_ascii' => ['boolean'],
    ];

    /**
     * @var array
     */
    protected $options;

    /**
     * @var \Illuminate\Database\Eloquent\Model
     */
    protected $model;

    /**
     * Create a new service instance.
     *
     * @param  \Illuminate\Database\Eloquent\Model|string|null $model
     * @return void
     */
    public function __construct(Model | string $model = null)
    {
        $this->options = config('username-generator');

        if (is_null($model)) {
            return;
        }

        if (is_string($model)) {
            $model = new $model();
        }

        throw_unless($model instanceof ShouldGeneratesUsername, new InvalidArgumentException("Model argument must implements ZedanLab\UsernameGenerator\Contracts\ShouldGeneratesUsername interface."));

        $this->model = $model;
        $this->mergeModelOptions();
    }

    /**
     * Mearging the given model options if the usernameGeneratorOptions method exists.
     *
     * @return void
     */
    protected function mergeModelOptions(): void
    {
        $model_options = method_exists($this->model, 'usernameGeneratorOptions')
        ? $this->model::usernameGeneratorOptions()
        : [];

        $this->options = array_merge($this->options, $model_options);
    }

    /**
     * Dynamically retrieve configuration option(s).
     *
     * @param  string  $key
     * @return mixed
     */
    public function __get($key)
    {
        return $this->getAttribute($key);
    }

    /**
     * Dynamically set configuration option(s).
     *
     * @param  string $key
     * @param  mixed  $value
     * @return void
     */
    public function __set(string $key, $value)
    {
        $this->set($key, $value);
    }

    /**
     * Get an attribute from an array using "dot" notation.
     *
     * @param  string  $key
     * @param  mixed   $default
     * @return mixed
     */
    public function getAttribute(string $key, $default = null)
    {
        if ($key === 'all') {
            return $this->all();
        }

        throw_unless(
            isset($this->optionsDataType[$key]),
            new InvalidArgumentException(sprintf('Invalid $key name "%s" not allowed. Allowed keys: %s', $key, implode(",", array_keys($this->optionsDataType))))
        );

        $value = Arr::get($this->options, $key, $default);

        throw_unless(
            in_array(gettype($value), $this->optionsDataType[$key]),
            new InvalidArgumentException(sprintf("'%s' must be in [%s], '%s' given.", $key, implode(",", $this->optionsDataType[$key]), ($value ?? 'null') . " => " . gettype($value)))
        );

        return $value;
    }

    /**
     * Set a attribute to a given value using "dot" notation.
     *
     * @param  string|array $keys
     * @param  null|mixed   $value
     * @return self
     */
    public function set($keys, $value = null)
    {
        if (is_array($keys)) {
            foreach ($keys as $key => $value) {
                $this->set($key, $value);
            }

            return $this;
        }

        if (!is_string($keys)) {
            throw new InvalidArgumentException('$key must be a string or array.');
        }

        Arr::set($this->options, $keys, $value);

        return $this;
    }

    /**
     * Retrieve all generator configuration.
     *
     * @return array
     */
    public function all()
    {
        return $this->options;
    }

    /**
     * Get any option value by key.
     *
     * @param  string                                          $key
     * @param  \Illuminate\Database\Eloquent\Model|string|null $model
     * @return mixed|array
     */
    public static function get($key = 'all', $model = null)
    {
        return (new static($model))->getAttribute($key);
    }
}
