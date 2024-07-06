<?php

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity()]
#[ORM\Table('product')]
class Product
{
	#[ORM\Id]
	#[ORM\Column(type: 'integer')]
	private int $article;
	#[ORM\Column(type: 'integer')]
	private int $quantity;
	#[ORM\Column(type: 'integer')]
	private int $price;
	#[ORM\Column(type: 'string')]
	private string $type;
	#[ORM\Column(type: 'string')]
	private string $name;
	#[ORM\Column(type: 'string')]
	private string $size;
	#[ORM\Column(type: 'string')]
	private string $brand;
	#[ORM\Column(type: 'string')]
	private string $model;
	#[ORM\Column(type: 'string')]
	private string $genre;
	#[ORM\Column(type: 'string')]
	private string $description;
	#[ORM\Column(type: 'datetime')]
	private string $created_at;
	#[ORM\Column(type: 'datetime')]
	private string $updated_at;

	/**
	 * @return int
	 */
	public function getArticle(): int
	{
		return $this->article;
	}

	/**
	 * @param int $article
	 * @return Product
	 */
	public function setArticle(int $article): Product
	{
		$this->article = $article;
		return $this;
	}

	/**
	 * @return int
	 */
	public function getQuantity(): int
	{
		return $this->quantity;
	}

	/**
	 * @param int $quantity
	 * @return Product
	 */
	public function setQuantity(int $quantity): Product
	{
		$this->quantity = $quantity;
		return $this;
	}

	/**
	 * @return int
	 */
	public function getPrice(): int
	{
		return $this->price / 100;
	}

	/**
	 * @param int $price
	 * @return Product
	 */
	public function setPrice(int $price): Product
	{
		$this->price = $price * 100;
		return $this;
	}

	/**
	 * @return string
	 */
	public function getType(): string
	{
		return $this->type;
	}

	/**
	 * @param string $type
	 * @return Product
	 */
	public function setType(string $type): Product
	{
		$this->type = $type;
		return $this;
	}

	/**
	 * @return string
	 */
	public function getName(): string
	{
		return $this->name;
	}

	/**
	 * @param string $name
	 * @return Product
	 */
	public function setName(string $name): Product
	{
		$this->name = $name;
		return $this;
	}

	/**
	 * @return string
	 */
	public function getSize(): string
	{
		return $this->size;
	}

	/**
	 * @param string $size
	 * @return Product
	 */
	public function setSize(string $size): Product
	{
		$this->size = $size;
		return $this;
	}

	/**
	 * @return string
	 */
	public function getBrand(): string
	{
		return $this->brand;
	}

	/**
	 * @param string $brand
	 * @return Product
	 */
	public function setBrand(string $brand): Product
	{
		$this->brand = $brand;
		return $this;
	}

	/**
	 * @return string
	 */
	public function getModel(): string
	{
		return $this->model;
	}

	/**
	 * @param string $model
	 * @return Product
	 */
	public function setModel(string $model): Product
	{
		$this->model = $model;
		return $this;
	}

	/**
	 * @return string
	 */
	public function getGenre(): string
	{
		return $this->genre;
	}

	/**
	 * @param string $genre
	 * @return Product
	 */
	public function setGenre(string $genre): Product
	{
		$this->genre = $genre;
		return $this;
	}

	/**
	 * @return string
	 */
	public function getDescription(): string
	{
		return $this->description;
	}

	/**
	 * @param string $description
	 * @return Product
	 */
	public function setDescription(string $description): Product
	{
		$this->description = $description;
		return $this;
	}

	/**
	 * @return string
	 */
	public function getCreatedAt(): string
	{
		return $this->created_at;
	}

	/**
	 * @param string $created_at
	 * @return Product
	 */
	public function setCreatedAt(string $created_at): Product
	{
		$this->created_at = $created_at;
		return $this;
	}

	/**
	 * @return string
	 */
	public function getUpdatedAt(): string
	{
		return $this->updated_at;
	}

	/**
	 * @param string $updated_at
	 * @return Product
	 */
	public function setUpdatedAt(string $updated_at): Product
	{
		$this->updated_at = $updated_at;
		return $this;
	}


}