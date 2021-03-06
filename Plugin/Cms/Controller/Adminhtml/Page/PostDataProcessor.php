<?php

namespace OuterEdge\Page\Plugin\Cms\Controller\Adminhtml\Page;

use Magento\Cms\Controller\Adminhtml\Page\PostDataProcessor as PagePostDataProcessor;

class PostDataProcessor
{
    public function beforeFilter(PagePostDataProcessor $subject, array $rawData)
    {
        $data = $rawData;
        // @todo It is a workaround to prevent saving this data in cms model and it has to be refactored in future
        foreach (['primary_image', 'secondary_image', 'tertiary_image'] as $image) {
            if (isset($data[$image]) && is_array($data[$image])) {
                if (!empty($data[$image]['delete'])) {
                    $data[$image] = null;
                } else {
                    if (isset($data[$image][0]['name'])) {
                        if (isset($data[$image][0]['tmp_name'])) {
                            $data['upload'][$image] = true;
                        }
                        $data[$image] = $data[$image][0]['name'];
                    } else {
                        unset($data[$image]);
                    }
                }
            }
        }
        return [$data];
    }
}
