<?

namespace MessageApi\Infra\Repository\Parser;

interface ParserInterface {

    /**
     * @param array $raw
     *
     * @return object
     */
    public function parseItem(array $raw);

    /**
     * @param array $rawCollection
     *
     * @return object
     */
    public function parseCollection(array $rawCollection);

}
