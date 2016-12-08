<?php
declare(strict_types=1);

namespace Accenture\Shopfinder\Model\Shop\Source;

use Magento\Framework\Option\ArrayInterface;

class Options extends AbstractSource implements ArrayInterface
{
    /**
     * get options
     *
     * @return array
     */
    public function toOptionArray()
    {
        $options = [];
        foreach ($this->options as $values) {
            $options[] = [
                'value' => $values['value'],
                'label' => __($values['label'])
            ];
        }
        return $options;

    }


}
