<?php

declare(strict_types=1);

namespace Certificationy\Cli\Loaders;

use Certificationy\Answer;
use Certificationy\Collections\Answers;
use Certificationy\Collections\Questions;
use Certificationy\Interfaces\LoaderInterface;
use Certificationy\Question;
use Symfony\Component\Finder\Finder;
use Symfony\Component\Yaml\Yaml;

/**
 * "Efficience_it"-compatible Yaml loader. Inspired by {@see \Certificationy\Loaders\YamlLoader}.
 *
 * @internal
 */
final class YamlLoader implements LoaderInterface
{
    /**
     * @var Questions
     */
    private $questions;

    /**
     * @var string
     */
    private $paths;

    public function __construct(array $paths)
    {
        $this->paths = $paths;
    }

    public function load(int $nbQuestions, array $categories): Questions
    {
        $data = $this->prepareFromYaml($categories, $this->paths);
        $dataMax = count($data);
        $nbQuestions = min($nbQuestions, $dataMax);

        $questions = new Questions();

        for ($i = 0; $i < $nbQuestions; ++$i) {
            $key = array_rand($data);
            $item = $data[$key];
            unset($data[$key]);

            $answers = new Answers();

            foreach ($item['answers'] as $dataAnswer) {
                $answers->addAnswer(new Answer($dataAnswer['value'], $dataAnswer['correct']));
            }

            if (!isset($item['shuffle']) || true === $item['shuffle']) {
                $answers->shuffle();
            }

            $help = isset($item['help']) ? $item['help'] : null;

            $questions->add($key, new Question($item['question'], $item['category'], $answers, $help));
        }

        return $questions;
    }

    /**
     * @throws \ErrorException
     */
    public function all(): Questions
    {
        if (is_null($this->questions)) {
            $this->questions = $this->load(PHP_INT_MAX, []);
        }

        return $this->questions;
    }

    public function categories(): array
    {
        $categories = [];
        $files = $this->prepareFromYaml([], $this->paths);

        foreach ($files as $file) {
            $categories[] = $file['category'];
        }

        return array_unique($categories);
    }

    /**
     * Prepares data from Yaml files and returns an array of questions
     *
     * @param array $categories : List of categories which should be included, empty array = all
     */
    protected function prepareFromYaml(array $categories = []): array
    {
        $data = [];

        foreach ($this->paths as $path) {
            $files = Finder::create()->files()->in($path)->name('*.yml')->name('*.yaml');

            foreach ($files as $file) {
                $fileData = Yaml::parse($file->getContents());
                $category = $fileData['category'];

                if (count($categories) > 0 && !in_array($category, $categories)) {
                    continue;
                }

                array_walk($fileData['questions'], function (&$item) use ($category) {
                    $item['category'] = $category;
                });

                $data = array_merge($data, $fileData['questions']);
            }
        }

        return $data;
    }
}
