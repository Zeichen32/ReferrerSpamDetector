<?php
/**
 * Created by Two Developers - Sven Motz und Jens Averkamp GbR
 * http://www.two-developers.com
 *
 * Author: Jens Averkamp
 */

namespace TwoDevs\ReferrerSpamDetector\Provider;

use Pdp\Uri\Url;

class PdoProvider implements ProviderInterface
{
    /** @var \PDO */
    protected $db;

    protected $table;

    protected $column;

    protected $query;

    /**
     * @param \PDO   $connection
     * @param string $table
     * @param string $column
     */
    public function __construct(\PDO $connection, $table, $column)
    {
        $this->db = $connection;
        $this->table = $table;
        $this->column = $column;
    }

    protected function buildQuery()
    {
        if (!$this->query) {
            $this->query = sprintf(
                'SELECT COUNT(`%2$s`) FROM `%s` as x WHERE (x.`%2$s` = :regDomain OR x.`%2$s` = :host OR x.`%2$s` = :pubSuffix) LIMIT 1',
                $this->table,
                $this->column
            );
        }

        return $this->query;
    }


    /**
     * {@inheritdoc}
     */
    public function isSpamReferrer(Url $url)
    {
        $url = $url->toArray();

        if (!isset($url['registerableDomain'], $url['host'], $url['publicSuffix'])) {
            return false;
        }

        $sth = $this->db->prepare($this->buildQuery());

        $sth->bindValue(':regDomain', $url['registerableDomain'], \PDO::PARAM_STR);
        $sth->bindValue(':host', $url['host'], \PDO::PARAM_STR);
        $sth->bindValue(':pubSuffix', $url['publicSuffix'], \PDO::PARAM_STR);

        $sth->execute([$url['registerableDomain'], $url['host'], $url['publicSuffix']]);

        if (!$sth->execute()) {
            return false;
        }

        return (int) $sth->fetchColumn() > 0;
    }
}
