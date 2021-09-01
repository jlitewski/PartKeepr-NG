<?php
namespace App\Util\Filters;

interface IAssociationProperty {
    public function getProperty(): string;

    public function setProperty(string $property): self;

    public function getAssociation(): string;

    public function setAssociation(string $association): self;
}