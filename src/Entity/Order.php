<?php

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;
use Doctrine\ORM\Mapping\JoinColumn;

#[ORM\Entity()]
#[ORM\Table(name: 'order')]
class Order
{
	#[ORM\Id]
	#[ORM\GeneratedValue(strategy: 'AUTO')]
	#[ORM\Column(type: 'integer')]
	private int $id;
	#[ORM\Column(type: 'integer')]
	#[ORM\ManyToOne(targetEntity: User::class, inversedBy: 'order')]
	#[JoinColumn(name: 'user_id', referencedColumnName: 'id')]
	private ?User $user;
	#[ORM\Column(type: 'integer')]
	private int $total_amount;
	#[ORM\Column(type: 'integer')]
	private int $status;
	#[ORM\Column(type: 'string')]
	private string $shipping_address;
	#[ORM\Column(type: 'string')]
	private string $billing_address;
	#[ORM\Column(type: 'string')]
	private string $payment_method;
	#[ORM\Column(type: 'datetime')]
	private string $created_at;
	#[ORM\Column(type: 'datetime')]
	private string $updated_at;

	public function getUser(): ?User
	{
		return $this->user;
	}

	public function setUser(?User $user): void
	{
		$this->user = $user;
	}

	/**
	 * @return int
	 */
	public function getId(): int
	{
		return $this->id;
	}

	/**
	 * @param int $id
	 * @return Order
	 */
	public function setId(int $id): Order
	{
		$this->id = $id;
		return $this;
	}

	/**
	 * @return float
	 */
	public function getTotalAmount(): float
	{
		return $this->total_amount / 100;
	}

	/**
	 * @param float $total_amount
	 * @return Order
	 */
	public function setTotalAmount(float $total_amount): Order
	{
		$this->total_amount = $total_amount * 100;
		return $this;
	}

	/**
	 * @return int
	 */
	public function getStatus(): int
	{
		return $this->status;
	}

	/**
	 * @param int $status
	 * @return Order
	 */
	public function setStatus(int $status): Order
	{
		$this->status = $status;
		return $this;
	}

	/**
	 * @return string
	 */
	public function getShippingAddress(): string
	{
		return $this->shipping_address;
	}

	/**
	 * @param string $shipping_address
	 * @return Order
	 */
	public function setShippingAddress(string $shipping_address): Order
	{
		$this->shipping_address = $shipping_address;
		return $this;
	}

	/**
	 * @return string
	 */
	public function getBillingAddress(): string
	{
		return $this->billing_address;
	}

	/**
	 * @param string $billing_address
	 * @return Order
	 */
	public function setBillingAddress(string $billing_address): Order
	{
		$this->billing_address = $billing_address;
		return $this;
	}

	/**
	 * @return string
	 */
	public function getPaymentMethod(): string
	{
		return $this->payment_method;
	}

	/**
	 * @param string $payment_method
	 * @return Order
	 */
	public function setPaymentMethod(string $payment_method): Order
	{
		$this->payment_method = $payment_method;
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
	 * @return Order
	 */
	public function setCreatedAt(string $created_at): Order
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
	 * @return Order
	 */
	public function setUpdatedAt(string $updated_at): Order
	{
		$this->updated_at = $updated_at;
		return $this;
	}


}