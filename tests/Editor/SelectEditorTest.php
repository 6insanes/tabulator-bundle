<?php

declare(strict_types=1);

namespace DeviantLab\TabulatorBundle\Tests\Editor;

use DeviantLab\TabulatorBundle\Editor\SelectEditor;
use PHPUnit\Framework\TestCase;

final class SelectEditorTest extends TestCase
{
    public function testValuesValidConstructor(): void
    {
        $select = new SelectEditor(
            values: ["red", "green", "blue", "orange"],
        );
        $this->assertInstanceOf(SelectEditor::class, $select);
        $select = new SelectEditor(
            valuesUrl: "http://myvalues.com",
        );
        $this->assertInstanceOf(SelectEditor::class, $select);
        $select = new SelectEditor(
            valuesLookup: "active",
        );
        $this->assertInstanceOf(SelectEditor::class, $select);
    }

    public function testValuesMultipleInvalidConstructor(): void
    {
        $this->expectException(\InvalidArgumentException::class);

        $select = new SelectEditor(
            values: ["red", "green", "blue", "orange"],
            valuesUrl: "http://myvalues.com",
        );
    }

    public function testValuesEmptyInvalidConstructor(): void
    {
        $this->expectException(\InvalidArgumentException::class);

        $select = new SelectEditor();
    }
}
