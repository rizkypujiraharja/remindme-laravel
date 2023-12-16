<?php

namespace Tests\Unit;

use App\Traits\ApiResponses;
use Illuminate\Http\JsonResponse;
use Tests\TestCase;

class ApiResponsesTest extends TestCase
{
    use ApiResponses;

    public function testSuccessApiResponse()
    {
        $response = $this->successApiResponse(['foo' => 'bar'], 'Test success', 200);
        $this->assertInstanceOf(JsonResponse::class, $response);
        $this->assertEquals(200, $response->getStatusCode());
        $this->assertEquals(['ok' => true, 'data' => ['foo' => 'bar']], $response->getData(true));
    }

    public function testErrorApiResponse()
    {
        $response = $this->errorApiResponse('Test error', 'ERR_TEST', 500, ['trace']);

        $this->assertInstanceOf(JsonResponse::class, $response);
        $this->assertEquals(500, $response->getStatusCode());
        $this->assertEquals(['ok' => false, 'err' => 'ERR_TEST', 'msg' => 'Test error', 'trace' => ['trace']], $response->getData(true));
    }

    public function testNotFound()
    {
        $response = $this->notFound();

        $this->assertInstanceOf(JsonResponse::class, $response);
        $this->assertEquals(404, $response->getStatusCode());
        $this->assertEquals(['ok' => false, 'err' => 'ERR_NOT_FOUND', 'msg' => 'Resource is not found'], $response->getData(true));
    }
}
