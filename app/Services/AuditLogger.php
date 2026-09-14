<?php

namespace App\Services;

use App\Models\AuditLog;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Auth;

class AuditLogger
{
    public function record(string $event, Model $subject, ?string $label = null, array $metadata = []): void
    {
        AuditLog::create([
            'user_id' => Auth::id(),
            'event' => $event,
            'subject_type' => class_basename($subject),
            'subject_id' => $subject->getKey(),
            'subject_label' => $label,
            'metadata' => $metadata ?: null,
            'ip_address' => request()?->ip(),
        ]);
    }
}
