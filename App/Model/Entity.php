<?php
namespace Model;

/**
 * is parent of entities
 */
class Entity
{
    public function __construct(array $datas)
    {
        if (!empty($datas)) {
            $this->hydrate($datas);
        }
    }

    /**
     * Hydrate his children from $datas
     * @param  array  $datas
     */
    protected function hydrate(array $datas)
    {
        foreach ($datas as $key => $value) {
            $method = 'set' . ucfirst($key);
            if (is_callable([$this, $method])) {
                $this->$method($value);
            }
        }
    }
}
