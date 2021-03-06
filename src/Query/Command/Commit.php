<?php

declare(strict_types=1);

/*
 * This file is part of Solr Client Symfony package.
 *
 * (c) ingatlan.com Zrt. <fejlesztes@ingatlan.com>
 *
 * This source file is subject to the MIT license that is bundled
 * with this source code in the file LICENSE.
 */

namespace iCom\SolrClient\Query\Command;

use iCom\SolrClient\JsonHelper;
use iCom\SolrClient\Query\Command;

/**
 * @see https://lucene.apache.org/solr/guide/8_3/uploading-data-with-index-handlers.html#commit-and-optimize-during-updates
 */
final class Commit implements Command
{
    use JsonHelper;

    private $options = [
        'waitSearcher' => null,
        'expungeDeletes' => null,
    ];

    public static function create(): self
    {
        return new self();
    }

    public function enableWaitSearcher(): self
    {
        $commit = clone $this;
        $commit->options['waitSearcher'] = true;

        return $commit;
    }

    public function disableWaitSearcher(): self
    {
        $commit = clone $this;
        $commit->options['waitSearcher'] = false;

        return $commit;
    }

    public function enableExpungeDeletes(): self
    {
        $commit = clone $this;
        $commit->options['expungeDeletes'] = true;

        return $commit;
    }

    public function disableExpungeDeletes(): self
    {
        $commit = clone $this;
        $commit->options['expungeDeletes'] = false;

        return $commit;
    }

    public function toJson(): string
    {
        return self::jsonEncode(array_filter($this->options, static function ($option) { return null !== $option; }), JSON_FORCE_OBJECT);
    }

    public function getName(): string
    {
        return 'commit';
    }
}
