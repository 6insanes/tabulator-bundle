<?php

declare(strict_types=1);


namespace DeviantLab\TabulatorBundle;

use DeviantLab\TabulatorBundle\Validator\ValidatorInterface;

final class Column
{
    public function __construct(
        public readonly ?string                       $title = null,
        public readonly ?string                       $field = null,
        public readonly ?bool                         $visible = null,
        public readonly ?int                          $width = null,
        public readonly ?int                          $widthGrow = null,
        public readonly ?int                          $widthShrink = null,
        public readonly ?bool                         $resizable = null,
        public readonly ?int                          $minWidth = null,
        public readonly ?int                          $maxWidth = null,
        public readonly ?bool                         $frozen = null,
        public readonly ?bool                         $headerFilter = null,
        public readonly ?bool                         $print = null,
        public readonly ?bool                         $headerSort = null,
        public readonly ?HozAlign                     $headerHozAlign = null,
        public readonly ?HozAlign                     $hozAlign = null,
        public readonly ?VertAlign                    $vertAlign = null,
        public readonly ?MutatorInterface             $mutator = null,
        public readonly ?AccessorInterface            $accessor = null,
        public readonly ?FormatterInterface           $formatter = null,
        public readonly ?EditorInterface              $editor = null,
        /**
         * @var ValidatorInterface|ValidatorInterface[]|null
         */
        public readonly ValidatorInterface|array|null $validator = null,
    )
    {

    }
}
