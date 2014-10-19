<?php
namespace inklabs\kommerce\Doctrine\Functions\Sqlite;

use \Doctrine\ORM\Query\AST\Functions\FunctionNode;
use \Doctrine\ORM\Query\Lexer;

/**
 * "RAND" "(" SimpleArithmeticExpression ")"
 */
class Rand extends FunctionNode
{
    private $arithmeticExpression = null;

    public function parse(\Doctrine\ORM\Query\Parser $parser)
    {
        $lexer = $parser->getLexer();

        $parser->match(Lexer::T_IDENTIFIER);
        $parser->match(Lexer::T_OPEN_PARENTHESIS);

        if (Lexer::T_CLOSE_PARENTHESIS !== $lexer->lookahead['type']) {
            $this->arithmeticExpression = $parser->SimpleArithmeticExpression();
        }

        $parser->match(Lexer::T_CLOSE_PARENTHESIS);
    }

    public function getSql(\Doctrine\ORM\Query\SqlWalker $sqlWalker)
    {
        if ($this->arithmeticExpression !== null) {
            return $this->arithmeticExpression->dispatch($sqlWalker) . ', RANDOM()';
        }

        return 'RANDOM()';
    }
}
