<?php

namespace App\Http\Requests\StepOne;

use Illuminate\Foundation\Http\FormRequest;

class UpdateStepOneRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, mixed>
     */
    public function rules()
    {
        return [
            'villageId' => 'required',
            'schoolId' => 'required',
            'headmaster' => 'required',
            'phoneHeadmaster' => 'required',
            'schoolOperator' => 'required',
            'phoneOperator' => 'required',
            'chairman' => 'required',
            'phoneChairman' => 'required',
            'image' => 'nullable|image|mimes:jpeg,png,jpg,gif',


        ];
    }
    public function messages()
    {
        return [
            'villageId.required' => 'Desa harus dipilih',
            'schoolId.required' => 'Sekolah harus dipilih',
            'headmaster.required' => 'Kepala desa harus diisi',
            'phoneHeadmaster.required' => 'Nomor telepon kepala desa harus diisi',
            'schoolOperator.required' => 'Operator sekolah diisi',
            'phoneOperator.required' => 'Nomor telepon harus diisi',
            'chairman.required' => 'Ketua komite harus diisi',
            'phoneChairman.required' => 'Nomor telepon ketua komite harus diisi',
            'image.required' => 'Foto harus diupload',
            'image.required' => 'Foto harus diupload',
            'image.image' => 'Foro harus gambar',
            'image.mimes' => 'Format foto yang didukung hanya jpeg,png,jpg,gif'

        ];
    }
}
