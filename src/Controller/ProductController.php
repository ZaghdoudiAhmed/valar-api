<?php

namespace App\Controller;

use App\Repository\ProductRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Messenger\Transport\Serialization\SerializerInterface;
use Symfony\Component\Routing\Attribute\Route;


#[Route('/api/products')]
class ProductController extends AbstractController
{

    private $productRepository;
    private $entityManager;
    private $serializer;

    public function __construct(ProductRepository $productRepository, EntityManagerInterface $entityManager, SerializerInterface $serializer)
    {
        $this->productRepository = $productRepository;
        $this->entityManager = $entityManager;
        $this->serializer = $serializer;
    }
    #[Route('', name: 'api_product_index', methods: ['GET'])]
    public function index(): JsonResponse
    {
        $products = $this->productRepository->findAll();
        return new JsonResponse($this->serializer->serialize($products, 'json', ['groups' => 'product:read']), Response::HTTP_OK, [], true);
    }

    #[Route('/{id}', name: 'api_product_show', methods: ['GET'])]
    public function show(int $id): JsonResponse
    {
        $product = $this->productRepository->find($id);
        if (!$product) {
            return new JsonResponse(['message' => 'Product not found'], Response::HTTP_NOT_FOUND);
        }

        return new JsonResponse($this->serializer->serialize($product, 'json', ['groups' => 'product:read']), Response::HTTP_OK, [], true);
    }

    #[Route('', name: 'api_product_new', methods: ['POST'])]
    public function new(Request $request): JsonResponse
    {
        $data = json_decode($request->getContent(), true);
        $product = new Product();
        $form = $this->createForm(ProductType::class, $product);
        $form->submit($data);

        if (!$form->isValid()) {
            return new JsonResponse($form->getErrors(), Response::HTTP_BAD_REQUEST);
        }

        $this->entityManager->persist($product);
        $this->entityManager->flush();

        return new JsonResponse($this->serializer->serialize($product, 'json', ['groups' => 'product:read']), Response::HTTP_CREATED, [], true);
    }

    #[Route('/{id}', name: 'api_product_edit', methods: ['PUT'])]
    public function edit(Request $request, int $id): JsonResponse
    {
        $product = $this->productRepository->find($id);
        if (!$product) {
            return new JsonResponse(['message' => 'Product not found'], Response::HTTP_NOT_FOUND);
        }

        $data = json_decode($request->getContent(), true);
        $form = $this->createForm(ProductType::class, $product);
        $form->submit($data);

        if (!$form->isValid()) {
            return new JsonResponse($form->getErrors(), Response::HTTP_BAD_REQUEST);
        }

        $this->entityManager->flush();

        return new JsonResponse($this->serializer->serialize($product, 'json', ['groups' => 'product:read']), Response::HTTP_OK, [], true);
    }

    #[Route('/{id}', name: 'api_product_delete', methods: ['DELETE'])]
    public function delete(int $id): JsonResponse
    {
        $product = $this->productRepository->find($id);
        if (!$product) {
            return new JsonResponse(['message' => 'Product not found'], Response::HTTP_NOT_FOUND);
        }

        $this->entityManager->remove($product);
        $this->entityManager->flush();

        return new JsonResponse(['message' => 'Product deleted'], Response::HTTP_NO_CONTENT);
    }
}
