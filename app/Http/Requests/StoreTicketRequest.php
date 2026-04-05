<?php

namespace App\Http\Requests;

use App\Models\Customer;
use App\Models\Ticket;
use Illuminate\Contracts\Validation\ValidationRule;
use Illuminate\Foundation\Http\FormRequest;

class StoreTicketRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        return [
            'name'        => ['required', 'string', 'max:255'],
            'email'       => ['required', 'email', 'max:255'],
            'phone'       => ['required', 'string', 'regex:/^\+?[1-9]\d{6,14}$/'],
            'topic'       => ['required', 'string', 'max:255'],
            'description' => ['required', 'string', 'max:5000'],
            'files'       => ['nullable', 'array', 'max:5'],
            'files.*'     => ['file', 'max:10240', 'mimes:jpg,jpeg,png,pdf,doc,docx'],
        ];
    }

    public function withValidator($validator): void
    {
        $validator->after(function ($validator) {
            if ($validator->errors()->any()) {
                return;
            }

            $email = $this->input('email');
            $phone = $this->input('phone');

            $hasTicketToday = Ticket::query()
                ->whereDate('created_at', today())
                ->whereHas('customer', function ($query) use ($email, $phone) {
                    $query->where('email', $email)
                        ->orWhere('phone', $phone);
                })
                ->exists();

            if ($hasTicketToday) {
                $validator->errors()->add(
                    'email',
                    'Вы уже отправляли заявку сегодня. Повторная отправка возможна через 24 часа.'
                );
            }
        });
    }

    public function messages(): array
    {
        return [
            'name.required'        => 'Укажите ваше имя.',
            'email.required'       => 'Укажите адрес электронной почты.',
            'email.email'          => 'Введите корректный адрес электронной почты.',
            'phone.required'       => 'Укажите номер телефона.',
            'phone.regex'          => 'Номер телефона должен быть в формате E.164 (например, +998901234567).',
            'topic.required'       => 'Укажите тему обращения.',
            'description.required' => 'Опишите ваш вопрос или проблему.',
            'description.max'      => 'Сообщение не должно превышать 5000 символов.',
            'files.max'            => 'Можно прикрепить не более 5 файлов.',
            'files.*.max'          => 'Размер файла не должен превышать 10 МБ.',
            'files.*.mimes'        => 'Допустимые форматы: jpg, png, pdf, doc, docx.',
        ];
    }
}
