<?php
namespace inklabs\kommerce\Doctrine\Functions\Mysql;

use Doctrine\ORM\Query\AST\Functions\FunctionNode;
use Doctrine\ORM\Query\Lexer;
use Doctrine;

/**
 * "DISTANCE" "(" fromLatitude, fromLongitude, toLatitude, toLongitude ")"
 */
class Distance extends FunctionNode
{
    /** @var Doctrine\ORM\Query\AST\Literal */
    protected $fromLatitude;

    /** @var Doctrine\ORM\Query\AST\Literal */
    protected $fromLongitude;

    /** @var Doctrine\ORM\Query\AST\Literal */
    protected $toLatitude;

    /** @var Doctrine\ORM\Query\AST\Literal */
    protected $toLongitude;

    public function parse(Doctrine\ORM\Query\Parser $parser)
    {
        $parser->match(Lexer::T_IDENTIFIER);
        $parser->match(Lexer::T_OPEN_PARENTHESIS);

        $this->fromLatitude = $parser->ArithmeticExpression();
        $parser->match(Lexer::T_COMMA);

        $this->fromLongitude = $parser->ArithmeticExpression();
        $parser->match(Lexer::T_COMMA);

        $this->toLatitude = $parser->ArithmeticExpression();
        $parser->match(Lexer::T_COMMA);

        $this->toLongitude = $parser->ArithmeticExpression();

        $parser->match(Lexer::T_CLOSE_PARENTHESIS);
    }

    /**
     * Haversine Formula
     * https://developers.google.com/maps/articles/phpsqlsearch_v3
     */
    public function getSql(Doctrine\ORM\Query\SqlWalker $sqlWalker)
    {
        $sql = 'ROUND(3959 * ACOS(' .
            'COS(RADIANS(' . $this->fromLatitude->dispatch($sqlWalker) . '))' .
            '* COS(RADIANS(' . $this->toLatitude->dispatch($sqlWalker) . '))' .
            '* COS(RADIANS(' . $this->toLongitude->dispatch($sqlWalker) . ')' .
            ' - RADIANS(' . $this->fromLongitude->dispatch($sqlWalker) . '))' .
            '+ SIN(RADIANS(' . $this->fromLatitude->dispatch($sqlWalker) . '))' .
            '* SIN(RADIANS(' . $this->toLatitude->dispatch($sqlWalker) . '))' .
            '), 3)';

        return $sql;
    }
}
