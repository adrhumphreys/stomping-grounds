<?php


for ($i = 1; $i <= 1000; $i++) {
    $fixture = <<<YAML
SilverStripe\CMS\Model\SiteTree:
  item1:
    Title: 'yikes'
YAML;

    file_put_contents('app/tests/example' . $i .'.yml', $fixture);

    $template = "<?php

class Example" . $i ."Test extends \\SilverStripe\\Dev\\SapphireTest
{
    protected function tearDown()
    {
        echo static::class . ' -> Memory in use: ' . memory_get_usage() . ' ('. ((memory_get_usage() / 1024) / 1024) .'M)' . PHP_EOL;
        parent::tearDown();
    }

    public function testLeak()
    {
        \$page = \\SilverStripe\\CMS\\Model\\SiteTree::create();
        \$this->assertInstanceOf(\\SilverStripe\\CMS\\Model\\SiteTree::class, \$page);
        \$page->write();
    }
}
";

    $fileName = sprintf('app/tests/Example%sTest.php', $i);

    file_put_contents($fileName, $template);
}




