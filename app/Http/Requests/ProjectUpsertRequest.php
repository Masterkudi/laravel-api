<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Support\Facades\Auth;

class ProjectUpsertRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        // Recupero l'utente autenticato
        $user = Auth::user();

        // se l'email è cudini.andrea@gmail.com lo faccio passare, altrimenti no.
        if ($user->email === "cudini.andrea@gmail.com") {
            // se ritorno true l'operazione viene permessa
            return true;
        }

        // se ritorno false, l'operazione viene bloccata e ritorna un errore 403
        return false;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        return [
            'title' => 'required|max:255',
            'body' => 'required',
            'image' => 'required|image|max:6000',
            'repository' => 'required|max:255',
            'is_published' => 'nullable|boolean',
            // exists si assicura che l'id passato esista nella tabella categories
            'type_id' => 'nullable|exists:types,id',
            "technologies" => "nullable",
        ];
    }

    /**
     * tra "" posso scrivere i messaggi di errore che appaiono in caso di non iserimento delle regole di validazione obbligatorie.
     *
     * @return array<string, string>
     */
    public function messages(): array
    {
        return [
            // per esempio
            'title.required' => "title is required",
            'title.max' => "Title is too long", // messaggio di errore se il titolo è troppo lungo
            'body.required' => "body is required",
            'image.required' => "image is required",
            'image.max' => "",
            'repository.required' => "The GitHub link is required",
        ];
    }
}
