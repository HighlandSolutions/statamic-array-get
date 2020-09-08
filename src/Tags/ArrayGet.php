<?php

namespace Highland\StatamicArrayGet\Tags;

use Illuminate\Support\Str;
use Statamic\Tags\Tags;

class ArrayGet extends Tags
{
    /**
     * {{ array_get:some_array_var.array_key }}
     * {{ array_get:some_array key="array_key" }}
     * {{ array_get key="{some_array_var}.array_key" }}
     *
     * @return mixed
     */
    public function wildcard($key)
    {
        $key = $key === 'index'
            ? $this->params->get('key')
            : implode('.', array_filter([$key, $this->params->get('key')]));
        $default = $this->params->get('default');

        return Str::startsWith($key, 'view:')
            ? $this->parseAsVariable($key, $default)
            : $this->context->get("page.{$key}", $this->context->get($key, $default));
    }

    /**
     * Parse a string as a variable.
     *
     * @param string $variableName Name of the variable. E.g. "view:some_variable.some_key".
     * @param mixed $default
     * @return mixed
     */
    private function parseAsVariable($variableName, $default)
    {
        $template = "{{ $variableName }}";
        $result   = $this->parser->parseVariables($template, $this->context);

        return $result === $template ? $default : $result;
    }
}
