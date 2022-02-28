<?php

namespace App\Repository;

use App\Models\NoteTime;
use Carbon\Carbon;
use Illuminate\Database\Eloquent\Collection;

class NoteTimeRepository
{
    /**
     * @param int $id
     * @param array|null $fields
     * @return NoteTime|null
     */
    public function findById(int $id, array $fields = null)
    {
        if(isset($fields)){
            return NoteTime::findOrFail($id, $fields);
        }
        return NoteTime::findOrFail($id);
    }

    public function getByRangeAndUser(Carbon $startAt, Carbon $endAt, int $userId, $except = 0): Collection
    {
        return NoteTime
            ::whereBetween('start_at',[$startAt, $endAt])
            ->whereUserId($userId)
            ->where('id', '!=', $except)
            ->get();
    }

    public function existsByRangeAndUser(Carbon $startAt, Carbon $endAt, int $userId, $except = 0): bool
    {
        return NoteTime
                ::whereBetween('start_at',[$startAt, $endAt])
                ->whereUserId($userId)
                ->where('id', '!=', $except)
                ->count() > 0;
    }

    public function existsStartAtAndUser(Carbon $startAt, int $userId, $except = 0): bool
    {
        return NoteTime
                ::where('start_at', $startAt)
                ->whereUserId($userId)
                ->where('id', '!=', $except)
                ->count() > 0;
    }

    public function existsEndAtAndUser(Carbon $startAt, int $userId, $except = 0): bool
    {
        return NoteTime
                ::where('end_at', $startAt)
                ->whereUserId($userId)
                ->where('id', '!=', $except)
                ->count() > 0;
    }
}
