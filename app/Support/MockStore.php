<?php

namespace App\Support;

use Carbon\Carbon;

/**
 * Session-backed stand-in for the database so every screen is fully interactive
 * before MySQL is connected. Controllers only talk to this class (or the Eloquent
 * models that will replace it), never to the session directly.
 */
class MockStore
{
    public static function all(string $key): array
    {
        return session()->get("ferms.data.$key", MockSeed::get($key));
    }

    public static function put(string $key, array $rows): void
    {
        session()->put("ferms.data.$key", $rows);
    }

    public static function find(string $key, int $id): array
    {
        $row = collect(static::all($key))->firstWhere('id', $id);
        abort_if($row === null, 404);

        return $row;
    }

    public static function insert(string $key, array $data): array
    {
        $rows = static::all($key);
        $data['id'] = (collect($rows)->max('id') ?? 0) + 1;
        array_unshift($rows, $data);
        static::put($key, $rows);

        return $data;
    }

    public static function update(string $key, int $id, array $data): void
    {
        static::put($key, array_map(
            fn ($r) => $r['id'] === $id ? array_merge($r, $data) : $r,
            static::all($key)
        ));
    }

    public static function log(string $message): void
    {
        $rows = static::all('activity');
        array_unshift($rows, $message.' — '.now()->format('g:i A'));
        static::put('activity', array_slice($rows, 0, 8));
    }

    public static function profile(string $role): array
    {
        return session()->get("ferms.profile.$role", MockSeed::get('profiles')[$role]);
    }

    public static function saveProfile(string $role, array $data): void
    {
        session()->put("ferms.profile.$role", array_merge(static::profile($role), $data));
    }

    public static function user(): ?array
    {
        return session('ferms.user');
    }

    /** Reservations belonging to the signed-in student. */
    public static function myReservations(): \Illuminate\Support\Collection
    {
        $name = static::profile('student')['name'];

        return collect(static::all('reservations'))->where('who', $name)->values();
    }

    public static function today(): Carbon
    {
        return Carbon::parse(config('ferms.today') ?: now())->startOfDay();
    }
}
