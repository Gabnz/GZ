<?php

namespace Hotel\BillBundle\DQL;

use Doctrine\ORM\Query\AST\Functions\FunctionNode;
use Doctrine\ORM\Query\Lexer;
use Doctrine\ORM\Query\Parser;
use Doctrine\ORM\Query\SqlWalker;

/**
 * Custom DQL function returning the difference between two DateTime values
 * 
 * usage TIME_DIFF(dateTime1, dateTime2)
 */
class TimeDiff extends FunctionNode
{


    public $dateTime1 = null;
    public $dateTime2 = null;

    public function parse(\Doctrine\ORM\Query\Parser $parser)
    {
        $parser->match(Lexer::T_IDENTIFIER);
        $parser->match(Lexer::T_OPEN_PARENTHESIS);
        $this->dateTime1 = $parser->ArithmeticPrimary();       
        $parser->match(Lexer::T_COMMA);
        $this->dateTime2 = $parser->ArithmeticPrimary();
        $parser->match(Lexer::T_CLOSE_PARENTHESIS);
    }

    public function getSql(\Doctrine\ORM\Query\SqlWalker $sqlWalker)
    {
        return 'TIMEDIFF(' .
            $this->dateTime1->dispatch($sqlWalker) . ', ' .
            $this->dateTime2->dispatch($sqlWalker) .
        ')'; 
    }
}