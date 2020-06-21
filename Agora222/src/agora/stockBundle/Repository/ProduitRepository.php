<?php


namespace agora\stockBundle\Repository;


use Doctrine\ORM\EntityRepository;

class ProduitRepository extends EntityRepository
{
    public function ProduitCatg($catg)
    {
        $ql=$this->getEntityManager()->createQuery("select p from stockBundle:Produit p where p.categorie=:catg")->setParameter('catg',$catg);
        return $query=$ql->getResult();
    }
    public function ProduitMarq($marq)
    {
        $ql=$this->getEntityManager()->createQuery("select p from stockBundle:Produit p where p.marque=:marq")->setParameter('marq',$marq);
        return $query=$ql->getResult();
    }
    public function FindProducts($prod)
    {
        $ql=$this->getEntityManager()->createQuery("select p from stockBundle:Produit p where p.nomProduit=:p")->setParameter('p',$prod);
        return $query=$ql->getResult();
    }
    public function FilterByPrice1()
    {
        $ql=$this->getEntityManager()->createQuery("select p from stockBundle:Produit p where p.prixVente>=1 and p.prixVente<=1000");
        return $query=$ql->getResult();
    }
    public function FilterByPrice2()
    {
        $ql=$this->getEntityManager()->createQuery("select p from stockBundle:Produit p where p.prixVente>1000 and p.prixVente<=10000");
        return $query=$ql->getResult();
    }
    public function FilterByPrice3()
    {
        $ql=$this->getEntityManager()->createQuery("select p from stockBundle:Produit p where p.prixVente>10000 and p.prixVente<=100000");
        return $query=$ql->getResult();
    }
    public function FilterByPrice4()
    {
        $ql=$this->getEntityManager()->createQuery("select p from stockBundle:Produit p where p.prixVente>100000 and p.prixVente<=1000000");
        return $query=$ql->getResult();
    }
    public function FilterByPrice5()
    {
        $ql=$this->getEntityManager()->createQuery("select p from stockBundle:Produit p where p.prixVente>1000000 and p.prixVente<=10000000");
        return $query=$ql->getResult();
    }

}
