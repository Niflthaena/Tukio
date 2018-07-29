<?php
declare(strict_types=1);

namespace Crell\Tukio;


use PHPUnit\Framework\TestCase;

class OrderedCollectionTest extends TestCase
{


    public function test_can_add_items_with_same_priority() : void
    {
        $c = new OrderedCollection();
        $c->addItem('A', 1);
        $c->addItem('B', 1);
        $c->addItem('C', 1);

        $results = iterator_to_array($c);

        $this->assertEquals('ABC', implode($results));
    }

    public function test_can_add_items_with_different_priority() : void
    {
        $c = new OrderedCollection();
        // High priority number comes first.
        $c->addItem('C', 1);
        $c->addItem('B', 2);
        $c->addItem('A', 3);

        $results = iterator_to_array($c);

        $this->assertEquals('ABC', implode($results));
    }

    public function test_can_add_items_with_same_and_different_priority() : void
    {
        $c = new OrderedCollection();
        // High priority number comes first.
        $c->addItem('C', 2);
        $c->addItem('B', 3);
        $c->addItem('A', 4);
        $c->addItem('D', 1);
        $c->addItem('E', 1);
        $c->addItem('F', 1);

        $results = iterator_to_array($c);

        $this->assertEquals('ABCDEF', implode($results));
    }

    public function test_can_add_items_before_other_items() : void
    {
        $c = new OrderedCollection();
        // High priority number comes first.
        $cid = $c->addItem('C', 2);
        $c->addItem('D', 1);
        $c->addItem('A', 3);

        $c->addItemBefore($cid, 'B');

        $results = implode(iterator_to_array($c));

        $this->assertTrue(strpos($results, 'B') < strpos($results, 'C'));
    }

    public function test_can_add_items_after_other_items() : void
    {
        $c = new OrderedCollection();
        // High priority number comes first.
        $c->addItem('C', 2);
        $c->addItem('D', 1);
        $aid = $c->addItem('A', 3);

        $c->addItemAfter($aid, 'B');

        $results = implode(iterator_to_array($c));

        $this->assertTrue(strpos($results, 'B') > strpos($results, 'A'));
    }
}
