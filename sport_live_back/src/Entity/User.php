<?php

namespace App\Entity;

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;
use App\Repository\UserRepository;
use Symfony\Component\Security\Core\User\UserInterface;
use Symfony\Component\Serializer\Annotation\Groups;

/**
 * @ORM\Entity(repositoryClass=UserRepository::class)
 */
class User implements UserInterface
{
    /**
     * @ORM\Id
     * @ORM\GeneratedValue
     * @ORM\Column(type="integer")
     * @Groups("user:read")
     */
    private $id;

    /**
     * @ORM\Column(type="string", length=255)
     * @Groups("user:read")
     */
    private $firstname;

    /**
     * @ORM\Column(type="string", length=255)
     * @Groups("user:read")
     */
    private $lastname;


    /**
     * @ORM\Column(type="string", length=255)
     */
    private $alias;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $email;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $password;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $role;

    /**
     * @ORM\OneToMany(targetEntity="App\Entity\Message", mappedBy="user")
     */
    private $messages;

    /**
     * @ORM\OneToMany(targetEntity=Poll::class, mappedBy="user")
     */
    private $polls;

    /**
     * @ORM\OneToMany(targetEntity=Answer::class, mappedBy="user")
     */
    private $answers;

    /**
     * @ORM\ManyToMany(targetEntity=Answer::class, inversedBy="users")
     */
    private $selectedAnswers;

    public function __construct()
    {
        $this->messages = new ArrayCollection();
        $this->polls = new ArrayCollection();
        $this->answers = new ArrayCollection();
        $this->selectedAnswers = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getFirstname(): ?string
    {
        return $this->firstname;
    }

    public function setFirstname(string $firstname): self
    {
        $this->firstname = $firstname;
        return $this;
    }

    public function getLastname(): ?string
    {
        return $this->lastname;
    }

    public function setLastname(string $lastname): self
    {
        $this->lastname = $lastname;
        return $this;
    }

    public function getAlias(): ?string
    {
        return $this->alias;
    }

    public function setAlias(string $alias): self
    {
        $this->alias = $alias;
        return $this;
    }

    public function getEmail(): ?string
    {
        return $this->email;
    }

    public function setEmail(string $email): self
    {
        $this->email = $email;
        return $this;
    }

    public function getPassword(): ?string
    {
        return $this->password;
    }

    public function setPassword(string $password): self
    {
        $this->password = $password;
        return $this;
    }

    public function getRole(): ?string
    {
        return $this->role;
    }

    public function setRole(string $role): self
    {
        $this->role = $role;
        return $this;
    }

    public function getMessages(): Collection
    {
        return $this->messages;
    }

    public function addMessage(Message $message): self
    {
        if (!$this->messages->contains($message)) {
            $this->messages[] = $message;
            $message->setUser($this);
        }

        return $this;
    }

    public function removeMessage(Message $message): self
    {
        if ($this->messages->contains($message)) {
            $this->messages->removeElement($message);
            if ($message->getUser() === $this) {
                $message->setUser(null);
            }
        }

        return $this;
    }

    public function getPolls(): Collection
    {
        return $this->polls;
    }

    public function addPoll(Poll $poll): self
    {
        if (!$this->polls->contains($poll)) {
            $this->polls[] = $poll;
            $poll->setUser($this);
        }

        return $this;
    }

    public function removePoll(Poll $poll): self
    {
        if ($this->polls->removeElement($poll)) {
            if ($poll->getUser() === $this) {
                $poll->setUser(null);
            }
        }

        return $this;
    }

    public function getAnswers(): Collection
    {
        return $this->answers;
    }

    public function addAnswer(Answer $answer): self
    {
        if (!$this->answers->contains($answer)) {
            $this->answers[] = $answer;
            $answer->setUser($this);
        }

        return $this;
    }

    public function removeAnswer(Answer $answer): self
    {
        if ($this->answers->removeElement($answer)) {
            if ($answer->getUser() === $this) {
                $answer->setUser(null);
            }
        }

        return $this;
    }

    public function getSelectedAnswers(): Collection
    {
        return $this->selectedAnswers;
    }

    public function addSelectedAnswer(Answer $selectedAnswer): self
    {
        if (!$this->selectedAnswers->contains($selectedAnswer)) {
            $this->selectedAnswers[] = $selectedAnswer;
        }

        return $this;
    }

    public function removeSelectedAnswer(Answer $selectedAnswer): self
    {
        $this->selectedAnswers->removeElement($selectedAnswer);
        return $this;
    }

    /**
 * Cette méthode est nécessaire pour l'interface UserInterface.
 * Elle renvoie les rôles accordés à l'utilisateur.
 * Chaque rôle est une chaîne de caractères (p.ex. 'ROLE_USER', 'ROLE_ADMIN').
 */
public function getRoles(): array
{
    return array_unique(['ROLE_USER', $this->getRole()]);
}

/**
 * Cette méthode est nécessaire pour l'interface UserInterface.
 * Pour certains mécanismes d'encodage de mot de passe anciens, une "salt" (sel) est utilisée en plus du mot de passe pour le hachage.
 * Avec l'encodage moderne, cela n'est généralement pas nécessaire.
 * Laisser cette méthode retourner null.
 */
public function getSalt()
{
    return null;
}

/**
 * Cette méthode est nécessaire pour l'interface UserInterface.
 * Elle renvoie le nom d'utilisateur qui est utilisé pour l'authentification.
 * Il s'agit de l'adresse e-mail de l'utilisateur.
 */
public function getUsername(): string
{
    return $this->getEmail();
}

/**
 * Cette méthode est nécessaire pour l'interface UserInterface depuis Symfony 5.3+.
 * Elle renvoie l'identifiant de l'utilisateur, qui pourrait être un nom d'utilisateur, une adresse e-mail, etc.
 * Dans les versions récentes de Symfony, cette méthode remplace getUsername() pour identifier un utilisateur.
 */
public function getUserIdentifier(): string
{
    return $this->getEmail();
}

/**
 * Cette méthode est nécessaire pour l'interface UserInterface.
 * Elle est utilisée pour effacer les informations sensibles de l'utilisateur qui ne devraient pas être persistées (par exemple, un mot de passe en clair).
 */
public function eraseCredentials()
{
}

}
