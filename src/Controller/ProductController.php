<?php

namespace App\Controller;

use App\Entity\Product;
use App\Entity\Tag;
use App\Form\ProductType;
use App\Form\TagType;
use Doctrine\Common\Collections\ArrayCollection;
use Symfony\Component\HttpFoundation\File\UploadedFile;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;

class ProductController extends Controller
{
    /**
     * @Route("/", name="product")
     */
    public function actionIndex()
    {
        return $this->render('product/index.html.twig');
    }

    /**
     * Matches list of /product with page
     *
     * @Route("/product/list/{page}", name="list", requirements={"page"="\d+"})
     */
    public function actionList($page=1)
    {
        $repository = $this->getDoctrine()->getRepository(Product::class);
        $products = $repository->findProductList();
        return $this->render('product/list.html.twig',[
            'products'=>$products
        ]);
    }

    /**
     * Create a new product
     *
     * @Route("/product/create", name="create")
     */
    public function actionCreate(Request $request)
    {
        $product = new Product();
        $form = $this->createForm(ProductType::class, $product);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager = $this->getDoctrine()->getManager();
            $product=$form->getData();
            /** @var UploadedFile $file */
            $file = $product->getImgPath();
            if($file = $file ?? null){
                $fileName = $this->generateUniqueFileName().'.'.$file->guessExtension();

                $file->move(
                    $this->getParameter('image_directory'),
                    $fileName
                );

                $product->setImgPath($fileName);
            }

            $product->setCreateAt(time());

            $originalTags = new ArrayCollection();
            foreach ($originalTags as $tag) {
                if (false === $product->getTags()->contains($tag)) {
                    // remove the Task from the Tag
                    $tag->getTasks()->removeElement($product);

                    $entityManager->persist($tag);
                }
            }

            $entityManager->persist($product);
            $entityManager->flush();


            return $this->redirect($this->generateUrl('product'));
        }

        return $this->render('product/create.html.twig',[
            'form'=>$form->createView(),
        ]);
    }

    /**
     * Update an exist product
     *
     * @Route("/product/{product_id}/edit", name="update",requirements={"product_id"="\d+"})
     */
    public function actionUpdate(Request $request,$product_id)
    {
        $entityManager = $this->getDoctrine()->getManager();
        $product = $this->loadProductEntity($product_id);

        $originalTags = new ArrayCollection();

        // Create an ArrayCollection of the current Tag objects in the database
        foreach ($product->getTags() as $tag) {
            $originalTags->add($tag);
        }

        $editForm = $this->createForm(ProductType::class, $product);

        $editForm->handleRequest($request);

        if ($editForm->isSubmitted() &&$editForm->isValid()) {
            $product=$editForm->getData();
            /** @var UploadedFile $file */
            $file = $product->getImgPath();
            if($file = ($file ?? null)){
                $fileName = $this->generateUniqueFileName().'.'.$file->guessExtension();

                $file->move(
                    $this->getParameter('image_directory'),
                    $fileName
                );

                $product->setImgPath($fileName);
            }

            $product->setUpdateAt(time());

            foreach ($originalTags as $tag) {
                if (false === $product->getTags()->contains($tag)) {

                    $tag->getProducts()->removeElement($product);

                    $entityManager->persist($tag);

                }
            }

            $entityManager->persist($product);
            $entityManager->flush();

            return $this->redirectToRoute('list');
        }

        return $this->render('product/update.html.twig',[
            'form'=>$editForm->createView(),
        ]);
    }

    /**
     * Matches /product/ with slug
     *
     * @Route("/product/{slug}", name="product_show")
     */
    public function actionView($slug)
    {
        // $slug will equal the dynamic part of the URL
        // e.g. at /blog/yay-routing, then $slug='yay-routing'

        // ...
    }

    /*
     * Load a Product Entity by ID
     * */
    private function loadProductEntity($id){
        $repository = $this->getDoctrine()->getRepository(Product::class);
        if(($product = $repository->find($id)) !== null){
            return $product;
        }else{
            throw $this->createNotFoundException('No product found');
        }
    }

    private function generateUniqueFileName()
    {
        return md5(uniqid());
    }

    public function actionAddTag(Request $request){
        $tag= new Tag();
        $form_tag = $this->createForm(TagType::class, $tag);
        $form_tag->handleRequest($request);

        if ($form_tag->isSubmitted() && $form_tag->isValid()) {
            $tag=$form_tag->getData();
            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->persist($tag);
            $entityManager->flush();
            return $this->json(['tag'=>$tag]);
        }else
            return false;
    }
}
