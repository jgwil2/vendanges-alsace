<?php

namespace Me\VendangesBundle\Entity;

use Doctrine\ORM\EntityRepository;

class AnnonceRepository extends EntityRepository
{
	public function findAllJoinedToVigneron()
	{
		$query = $this->getEntityManager()
			->createQuery(
				'SELECT a, v FROM MeVendangesBundle:Annonce a
				JOIN a.vigneron v'
			);

		try{
			return $query->getResult();
		}
		catch(\Doctrine\ORM\NoResultException $e) {
			return null;
		}
	}

	public function findAllByVigneron($id)
	{
		$query = $this->getEntityManager()
			->createQuery(
				'SELECT a FROM MeVendangesBundle:Annonce a
				WHERE a.vigneron = :id'
				)->setParameter('id', $id);

		try{
			return $query->getResult();
		}
		catch(\Doctrine\ORM\NoResultException $e) {
			return null;
		}
	}

	public function findOneByIdJoinedToVigneron($id)
	{
		$query = $this->getEntityManager()
			->createQuery(
				'SELECT a, v FROM MeVendangesBundle:Annonce a
				JOIN a.vigneron v
				WHERE a.id = :id'
			)->setParameter('id', $id);

		try{
			return $query->getSingleResult();
		}
		catch(\Doctrine\ORM\NoResultException $e) {
			return null;
		}
	}
}