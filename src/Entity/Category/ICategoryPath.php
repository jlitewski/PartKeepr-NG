<?php
namespace App\Entity\Category;

/** @package App\Entity\Category */
interface ICategoryPath {
    /**
     * Sets the category path.
     *
     * @param string $categoryPath The category path
     * @return self
     */
    public function setCategoryPath(string $categoryPath): self;

    /**
     * Generates the category path.
     *
     * @param string $pathSeparator The path separator
     *
     * @return string The category path
     */
    public function generateCategoryPath(string $pathSeparator): string;
}