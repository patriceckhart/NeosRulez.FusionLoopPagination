<?php
namespace NeosRulez\FusionLoopPagination\Fusion;

use Neos\Flow\Annotations as Flow;
use Neos\Fusion\FusionObjects\AbstractFusionObject;

class PaginationArrayImplementation extends AbstractFusionObject {

    /**
     * @return array
     */
    public function evaluate() {
        /*
         * This snippet comes from https://github.com/Flowpack/Flowpack.Listable
         * Extended by Marvin Schieler https://neos.arsors.de
         * */
        $maximumNumberOfLinks = intval($this->fusionValue('paginationMaxAmount')) - 2;
        $paginationMaxAmount = intval($this->fusionValue('paginationMaxAmount'));
        $itemsPerPage = intval($this->fusionValue('itemsPerPage'));
        $totalCount = intval($this->fusionValue('itemsTotalAmount'));
        $currentPage = intval($this->fusionValue('currentPage'));
        if ($totalCount > 0 !== true) {
            return [];
        }
        $numberOfPages = ceil($totalCount / $itemsPerPage);
        if ($maximumNumberOfLinks > $numberOfPages) {
            $maximumNumberOfLinks = $numberOfPages;
        }
        $delta = floor($maximumNumberOfLinks / 2);
        $displayRangeStart = $currentPage - $delta;
        $displayRangeEnd = $currentPage + $delta + ($maximumNumberOfLinks % 2 === 0 ? 1 : 0);
        if ($displayRangeStart < 1) {
            $displayRangeEnd -= $displayRangeStart - 1;
        }
        if ($displayRangeEnd > $numberOfPages) {
            $displayRangeStart -= ($displayRangeEnd - $numberOfPages);
        }
        $displayRangeStart = (integer)max($displayRangeStart, 1);
        $displayRangeEnd = (integer)min($displayRangeEnd, $numberOfPages);
        $links = \range($displayRangeStart, $displayRangeEnd);
        if ($displayRangeStart >= 2) {
            if ($displayRangeStart > 2) array_unshift($links, "...");
            if ($displayRangeStart == 2) {
                array_pop($links);
            }
            array_unshift($links, 1);
        }
        if ($displayRangeEnd + 1 <= $numberOfPages) {
            if($displayRangeEnd + 1 < $numberOfPages) $links[] = "...";
            if($displayRangeEnd + 1 == $numberOfPages) unset($links[2]);
            $links[] = $numberOfPages;
        }


        $enableFirst = $this->fusionValue('enableFirst');
        $enableLast = $this->fusionValue('enableLast');
        $enableArrows = $this->fusionValue('enableArrows');

        $showFirst = false;
        $showLast = false;
        $showArrows = [false,false];

        if ($enableFirst && $currentPage != 1) $showFirst = 1;
        if ($enableLast && $currentPage != $numberOfPages) $showLast = $numberOfPages;
        if ($enableArrows) {
            if ($currentPage != 1) $showArrows[0] = $currentPage-1;
            if ($currentPage != $numberOfPages) $showArrows[1] = $currentPage+1;
        }

        return [
            'raw'=> [
                'itemsTotalAmount' => $totalCount,
                'currentPage' => $currentPage,
                'itemsPerPage' => $itemsPerPage,
                'paginationMaxAmount' => $paginationMaxAmount,
            ],
            'first' => $showFirst,
            'previous'=>$showArrows[0],
            'pagination'=>$links,
            'next'=>$showArrows[1],
            'last'=>$showLast
        ];
    }
}