<?php

namespace NavItemPageTest;

use cmstests\WebModelTestCase;
use luya\testsuite\traits\CmsDatabaseTableTrait;
use yii\base\ViewNotFoundException;

class NavItemPageTest extends WebModelTestCase
{
    use CmsDatabaseTableTrait;

    public function testAppAliasViewPath()
    {
        $pageFixture = $this->createCmsNavItemPageFixture([
            1 => [
                'id' => 1,
                'layout_id' => 1,
                'nav_item_id' => 1,
            ]
        ]);
        $layoutFixture = $this->createCmsLayoutFixture([
            1 => [
                'id' => 1,
                'name' => 'id1',
                'json_config' => '{}',
                'view_file' => '@app/testfile',
            ]
        ]);
        
        $model = $pageFixture->getModel(1);

        try {
            $model->getContent();
        } catch (\Exception $e) {
            $this->assertContains('luya-module-cms/testfile', $e->getMessage());
        }
    }

    public function testAbsolutePath()
    {
        $pageFixture = $this->createCmsNavItemPageFixture([
            1 => [
                'id' => 1,
                'layout_id' => 1,
                'nav_item_id' => 1,
            ]
        ]);
        $layoutFixture = $this->createCmsLayoutFixture([
            1 => [
                'id' => 1,
                'name' => 'id1',
                'json_config' => '{}',
                'view_file' => '/absolute',
            ]
        ]);
        
        $model = $pageFixture->getModel(1);

        try {
            $model->getContent();
        } catch (\Exception $e) {
            $this->assertContains('/absolute', $e->getMessage());
        }
    }

    public function testRelativeViewPath()
    {
        $pageFixture = $this->createCmsNavItemPageFixture([
            1 => [
                'id' => 1,
                'layout_id' => 1,
                'nav_item_id' => 1,
            ]
        ]);
        $layoutFixture = $this->createCmsLayoutFixture([
            1 => [
                'id' => 1,
                'name' => 'id1',
                'json_config' => '{}',
                'view_file' => 'relative',
            ]
        ]);
        
        $model = $pageFixture->getModel(1);

        try {
            $model->getContent();
        } catch (\Exception $e) {
            $this->assertContains('luya-module-cms/views/cmslayouts/relative.php', $e->getMessage());
        }
    }
}