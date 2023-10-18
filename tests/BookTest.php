<?php

namespace App\Tests;


use PHPUnit\Framework\TestCase;
use App\Entity\Book;

class BookTest extends TestCase
{
    public function testTitleIsNotEmpty()
    {
        $book = new Book();
        $book->setTitle('44444');
        $this->assertNotEmpty($book->getTitle());
    }
}

