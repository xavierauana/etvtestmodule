<?php
/**
 * Author: Xavier Au
 * Date: 11/1/2017
 * Time: 6:11 PM
 */

namespace Anacreation\Etvtest\Services;


use Anacreation\Etvtest\Contracts\TestableInterface;
use Anacreation\Etvtest\Models\Test;
use Illuminate\Support\Collection;

/**
 * Class TestServices
 * @package Anacreation\Etvtest\Services
 */
class TestServices
{
    /**
     * @var \Anacreation\Etvtest\Contracts\TestableInterface|null
     */
    private $testableObject = null;


    /**
     * Test constructor.
     * @param \Anacreation\Etvtest\Contracts\TestableInterface $testableObject
     */
    public function __construct(TestableInterface $testableObject = null) {
        if ($testableObject) {
            $this->testableObject = $testableObject;
        }
    }

    /**
     * @return Collection
     */
    public function getTests() {
        return $this->testableObject->tests;
    }


    /**
     * @param \Anacreation\Etvtest\Contracts\TestableInterface $testableObject
     * @return \Illuminate\Support\Collection
     */
    public function getTestsByQuery(TestableInterface $testableObject) {

        $this->setTestableObject($testableObject);

        return $this->getTests();
    }

    /**
     * @param $id
     * @return \Illuminate\Database\Eloquent\Collection|\Illuminate\Database\Eloquent\Model
     */
    public function getTestById($id) {
        return Test::with([
            'questions' => function ($query) {
                return $query->with(['answer', 'choices', 'subQuestions']);
            }
        ])->findOrFail($id);
    }

    /**
     * @param \Anacreation\Etvtest\Contracts\TestableInterface|null $testableObject
     */
    public function setTestableObject($testableObject) {
        $this->testableObject = $testableObject;
    }

    /**
     * @param $id
     * @return \Anacreation\Etvtest\Models\Test|\Illuminate\Database\Eloquent\Model
     */
    public function getTestByIdForStudents($id) {
        return Test::with([
            'Questions' => function ($query) {
                $query->isActive()->with([
                    "Choices" => function ($query) {
                        $query->limitedInfo();
                    }
                ]);
            }
        ])->findOrFail($id);
    }


    /**
     * @param \Anacreation\Etvtest\Contracts\TestableInterface $testableObject
     * @param array                                            $data
     * @return \Anacreation\Etvtest\Models\Test
     */
    public function createTest(TestableInterface $testableObject, array $data): Test {

        return $testableObject->tests()->create(['title' => $data['title']]);
    }

    /**
     * @param $id
     */
    public function deleteById($id): void {
        Test::findOrFail($id)->delete();
    }


    public function updateTestById(int $id, array $data): void {
        Test::findOrFail($id)->update($data);
    }

}