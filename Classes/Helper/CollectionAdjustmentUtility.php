<?php

namespace Sandstorm\CrudForms\Helper;


use Doctrine\Common\Collections\Collection;

class CollectionAdjustmentUtility
{
    static public function similarize(Collection $target, Collection $source)
    {
        foreach ($target as $element) {
            if (!$source->contains($element)) {
                $target->removeElement($element);
            }
        }
        foreach ($source as $element) {
            if (!$target->contains($element)) {
                $target->add($element);
            }
        }

    }
}
