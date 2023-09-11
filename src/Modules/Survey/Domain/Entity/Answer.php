<?php

declare(strict_types=1);

namespace App\Modules\Survey\Domain\Entity;

use App\Modules\Survey\Domain\ValueObject\AnswerId;

class Answer
{
    private ?string $id = null;

    private ?int $quality = null;

    private ?string $comment = null;

    public function getId(): ?AnswerId
    {
        return new AnswerId($this->id);
    }

    public function setId(AnswerId $id): self
    {
        $this->id = $id->getValue();

        return $this;
    }

    public function getQuality(): ?int
    {
        return $this->quality;
    }

    public function setQuality(int $quality): self
    {
        $this->quality = $quality;

        return $this;
    }

    public function getComment(): ?string
    {
        return $this->comment;
    }

    public function setComment(string $comment): self
    {
        $this->comment = $comment;

        return $this;
    }

//    #[Assert\Callback]
//    public function validateComment(ExecutionContextInterface $context, $payload): void
//    {
//         require comment when negative recommendation
//        if ($this->getComment() === null && in_array($this->getQuality(), [-2, -1], true)) {
//            $context
//                ->buildViolation('Comment is required for poor quality')
//                ->atPath('comment')
//                ->addViolation();
//        } else if ($this->getComment() !== null && in_array($this->getQuality(), [0, 1, 2], true)) {
//            $context
//                ->buildViolation('There should be no comment when good quality')
//                ->atPath('comment')
//                ->addViolation();
//        }
//    }
}
