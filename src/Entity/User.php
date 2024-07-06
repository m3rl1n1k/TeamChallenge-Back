<?php

namespace App\Entity;

use App\Repository\UserRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: UserRepository::class)]
#[ORM\Table(name: 'user')]
class User
{
	#[ORM\Id]
	#[ORM\GeneratedValue(strategy: 'AUTO')]
	#[ORM\Column(type: 'integer')]
	private int $id;
	#[ORM\Column(type: 'string', options: ['unique' => true])]
	private string $email;
	#[ORM\Column(type: 'string', length: 100)]
	private string $password;
	#[ORM\OneToMany(targetEntity: Order::class, mappedBy: 'user')]
	private ?ArrayCollection $orders;
	#[ORM\Column(type: 'string')]
	private array $roles;
	#[ORM\Column(type: 'string')]
	private string $first_name;
	#[ORM\Column(type: 'string', nullable: true)]
	private string $last_name;
	#[ORM\Column(type: 'string', nullable: true)]
	private string $address;
	#[ORM\Column(type: 'string', nullable: true)]
	private string $city;
	#[ORM\Column(type: 'string', nullable: true)]
	private string $state;
	#[ORM\Column(type: 'string', nullable: true)]
	private string $zip_code;
	#[ORM\Column(type: 'string', nullable: true)]
	private string $phone;

	public function __construct()
	{
		$this->orders = new ArrayCollection();
	}

	/**
	 * @return int
	 */
	public function getId(): int
	{
		return $this->id;
	}

	/**
	 * @return string
	 */
	public function getEmail(): string
	{
		return $this->email;
	}

	/**
	 * @param string $email
	 * @return User
	 */
	public function setEmail(string $email): User
	{
		$this->email = $email;
		return $this;
	}

	/**
	 * @return string
	 */
	public function getPassword(): string
	{
		return $this->password;
	}

	/**
	 * @param string $password
	 * @return User
	 */
	public function setPassword(string $password): User
	{
		$this->password = $password;
		return $this;
	}

	/**
	 * @return array
	 */
	public function getRole(): array
	{
		$roles = $this->roles;
		// guarantee every user at least has ROLE_USER
		$roles[] = 'ROLE_USER';

		return array_unique($roles);
	}

	/**
	 * @param array $roles
	 * @return User
	 */
	public function setRole(array $roles): User
	{
		$this->roles = $roles;
		return $this;
	}

	/**
	 * @return string
	 */
	public function getFirstName(): string
	{
		return $this->first_name;
	}

	/**
	 * @param string $first_name
	 * @return User
	 */
	public function setFirstName(string $first_name): User
	{
		$this->first_name = $first_name;
		return $this;
	}

	/**
	 * @return string
	 */
	public function getLastName(): string
	{
		return $this->last_name;
	}

	/**
	 * @param string $last_name
	 * @return User
	 */
	public function setLastName(string $last_name): User
	{
		$this->last_name = $last_name;
		return $this;
	}

	/**
	 * @return string
	 */
	public function getAddress(): string
	{
		return $this->address;
	}

	/**
	 * @param string $address
	 * @return User
	 */
	public function setAddress(string $address): User
	{
		$this->address = $address;
		return $this;
	}

	/**
	 * @return string
	 */
	public function getCity(): string
	{
		return $this->city;
	}

	/**
	 * @param string $city
	 * @return User
	 */
	public function setCity(string $city): User
	{
		$this->city = $city;
		return $this;
	}

	/**
	 * @return string
	 */
	public function getState(): string
	{
		return $this->state;
	}

	/**
	 * @param string $state
	 * @return User
	 */
	public function setState(string $state): User
	{
		$this->state = $state;
		return $this;
	}

	/**
	 * @return string
	 */
	public function getZipCode(): string
	{
		return $this->zip_code;
	}

	/**
	 * @param string $zip_code
	 * @return User
	 */
	public function setZipCode(string $zip_code): User
	{
		$this->zip_code = $zip_code;
		return $this;
	}

	/**
	 * @return string
	 */
	public function getPhone(): string
	{
		return $this->phone;
	}

	/**
	 * @param string $phone
	 * @return User
	 */
	public function setPhone(string $phone): User
	{
		$this->phone = $phone;
		return $this;
	}

	/**
	 * @return Collection
	 */
	public function getOrders(): Collection
	{
		return $this->orders;
	}

	public function addOrder(Order $order): self
	{
		if (!$this->orders->contains($order)) {
			$this->orders[] = $order;
			$order->setUser($this);
		}

		return $this;
	}

	public function removeOrder(Order $order): self
	{
		if ($this->orders->removeElement($order)) {
			// set the owning side to null (unless already changed)
			if ($order->getUser() === $this) {
				$order->setUser(null);
			}
		}

		return $this;
	}

}