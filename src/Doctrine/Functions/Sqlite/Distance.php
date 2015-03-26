<?php
namespace inklabs\kommerce\Doctrine\Functions\Sqlite;

use Doctrine\ORM\Query\AST\Functions\FunctionNode;
use Doctrine\ORM\Query\Lexer;
use Doctrine as Doctrine;

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
     * Simple Manhattan Distance
     * 69.09 = approximate number of miles per degree of latitude.
     */
    public function getSql(Doctrine\ORM\Query\SqlWalker $sqlWalker)
    {
        $sql = 'ROUND(ABS(' . $this->fromLatitude->dispatch($sqlWalker) .
                ' - ' . $this->toLatitude->dispatch($sqlWalker) .
            ') + ABS(' . $this->fromLongitude->dispatch($sqlWalker) .
                ' - ' . $this->toLongitude->dispatch($sqlWalker) .
            ') * 69.09, 3)';

        return $sql;
    }
}
