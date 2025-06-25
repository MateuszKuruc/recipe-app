<script setup lang="ts">
import InputError from '@/components/InputError.vue';
import { Button } from '@/components/ui/button';
import { Input } from '@/components/ui/input';
import { Label } from '@/components/ui/label';
import AuthBase from '@/layouts/AuthLayout.vue';
import { Head, useForm } from '@inertiajs/vue3';
import { LoaderCircle } from 'lucide-vue-next';
import AppLayout from '@/layouts/AppLayout.vue';
import { ref } from 'vue';

defineProps({
    categories: Array
})

const form = useForm({
    category_id: '',
    title: '',
    excerpt: '',
    ingredients: '',
    prepare_time: '',
    cooking_time: '',
    servings: '',
    instructions: '',
    main_image: null,
    secondary_image: null,
});

const submit = () => {
    if(!validateStep3()) {
        return
    }

    form.post(route('recipes.store'), {
        forceFormData: true,
        onFinish: () => form.reset()
    })
}

const currentStep = ref(1);
const maxStep = 3;

const mainImagePreview = ref(null);
const secondaryImagePreview = ref(null);

const validateStep1 = () => {
    form.clearErrors();
    let hasError = false;

    if (!form.category_id) {
        form.setError('category_id', 'Wybierz kategorię');
        hasError = true;
    }
    if (!form.title) {
        form.setError('title', 'Podaj nazwę przepisu');
        hasError = true;
    }
    if (!form.excerpt) {
        form.setError('excerpt', 'Podaj krótki opis');
        hasError = true;
    }

    return !hasError
}

const validateStep2 = () => {
    form.clearErrors();
    let hasError = false;

    if (!form.ingredients) {
        form.setError('ingredients', 'Dodaj składniki');
        hasError = true;
    }
    if (form.prepare_time === null || form.prepare_time === undefined || form.prepare_time === '') {
        form.setError('prepare_time', 'Podaj czas przygotowania');
        hasError = true;
    }
    if (form.cooking_time === null || form.cooking_time === undefined || form.cooking_time === '') {
        form.setError('cooking_time', 'Podaj czas gotowania');
        hasError = true;
    }
    if (!form.servings) {
        form.setError('servings', 'Wybierz liczbę porcji');
        hasError = true;
    }

    return !hasError
}


const validateStep3 = () => {
    form.clearErrors();
    let hasError = false;

    if (!form.instructions) {
        form.setError('instructions', 'Dodaj instrukcję');
        hasError = true;
    }
    if (!form.main_image) {
        form.setError('main_image', 'Dodaj zdjęcie dania');
        hasError = true;
    }

    return !hasError
}

const handleNextStep = () => {
    if (currentStep.value === 1) {
        if (validateStep1()) {
            currentStep.value++
        }
    } else if (currentStep.value === 2) {
        if (validateStep2()) {
            currentStep.value++
        }
    } else if (currentStep.value === 3) {
        if (validateStep3()) {
            submit()
        }
    }
}

const handleMainImageUpload = (e: Event) => {
    const file = (e.target as HTMLInputElement).files?.[0];
    if (file) {
        form.main_image = file;
        mainImagePreview.value = URL.createObjectURL(file)
    }
};

const handleSecondaryImageUpload = (e: Event) => {
    const file = (e.target as HTMLInputElement).files?.[0];
    if (file) {
        form.secondary_image = file;
        secondaryImagePreview.value = URL.createObjectURL(file)
    }
};


</script>

<template>
    <AppLayout>
    <AuthBase title="Dodaj nowy przepis" description="Uzupełnij wymagane pola i zapisz swój przepis!">
        <Head title="Nowy przepis" />

        <form @submit.prevent="submit" class="flex flex-col gap-6">
            <div v-if="currentStep === 1" class="grid gap-6">

                <div class="grid gap-2">
                    <Label for="category">Kategoria</Label>
                    <select name="category" id="category" v-model="form.category_id" class="input w-full rounded border px-3 py-2">
                        <option value="" disabled selected>
                            Wybierz kategorię
                        </option>
                        <option v-for="category in categories" :key="category.id" :value="category.id">
                            {{ category.name }}
                        </option>

                    </select>
                    <InputError :message="form.errors.category_id" />
                </div>

                <div class="grid gap-2">
                    <Label for="title">Nazwa</Label>
                    <Input id="title" type="text" required v-model="form.title" placeholder="Pizza" />
                    <InputError :message="form.errors.title" />
                </div>

                <div class="grid gap-2">
                    <Label for="excerpt">Krótki opis</Label>
                    <textarea id="excerpt" v-model="form.excerpt" rows="3" placeholder="Napisz kilka słów o przepisie" class="rounded border px-3 py-2"></textarea>
                    <InputError :message="form.errors.excerpt" />
                </div>

            </div>
                <div v-if="currentStep === 2" class="grid gap-6">

                <div class="grid gap-2">
                    <Label for="ingredients">Składniki</Label>
                    <textarea id="ingredients" rows="3" v-model="form.ingredients" placeholder="300g kurczaka, 2 papryki..." class="rounded border px-3 py-2"></textarea>
                    <InputError :message="form.errors.ingredients" />
                </div>

                <div class="grid gap-2">
                    <Label for="prepare_time">Czas przygotowania</Label>
                    <select name="prepare_time" id="prepare_time" v-model="form.prepare_time" class="rounded border px-3 py-2">
                        <option value="" disabled selected>
                            Wybierz wartość
                        </option>
                        <option :value="0">0 min</option>
                        <option :value="5">5 min</option>
                        <option :value="15">15 min</option>
                        <option :value="30">30 min</option>
                        <option :value="45">45 min</option>
                        <option :value="60">1 godz.</option>
                        <option :value="90">1 godz. 30 min</option>
                        <option :value="120">ponad 2 godz.</option>
                    </select>
                    <InputError :message="form.errors.prepare_time" />
                </div>

                    <div class="grid gap-2">
                        <Label for="cooking_time">Czas gotowania</Label>
                        <select name="cooking_time" id="cooking_time" v-model="form.cooking_time" class="rounded border px-3 py-2">
                            <option value="" disabled selected>
                                Wybierz wartość
                            </option>
                            <option :value="0">0 min</option>
                            <option :value="5">5 min</option>
                            <option :value="15">15 min</option>
                            <option :value="30">30 min</option>
                            <option :value="45">45 min</option>
                            <option :value="60">1 godz.</option>
                            <option :value="75">1 godz. 15 min</option>
                            <option :value="90">1 godz. 30 min</option>
                            <option :value="120">ponad 2 godz.</option>
                        </select>
                        <InputError :message="form.errors.cooking_time" />
                    </div>

                    <div class="grid gap-2">
                        <Label for="servings">Liczba porcji</Label>
                        <select name="servings" id="servings" v-model="form.servings" class="rounded border px-3 py-2">
                            <option value="" disabled selected>
                                Wybierz wartość
                            </option>
                            <option :value="1">dla 1 osoby</option>
                            <option :value="2">dla 2 osób</option>
                            <option :value="3">dla 3 osób</option>
                            <option :value="4">dla 4 osób</option>
                            <option :value="5">dla 5 osób</option>
                            <option :value="6">dla 6 osób</option>


                        </select>
                        <InputError :message="form.errors.servings" />
                    </div>


                    </div>
            <div v-if="currentStep === 3" class="grid gap-6">

                <div class="grid gap-2">
                    <Label for="instructions">Instrukcja</Label>
                    <textarea id="instructions" v-model="form.instructions" rows="3" placeholder="Opisz wszystkie kroki" class="rounded border px-3 py-2"></textarea>
                    <InputError :message="form.errors.instructions" />
                </div>

                <div class="grid gap-2">
                    <Label for="main_image">Zdjęcie główne</Label>
                    <img v-if="mainImagePreview" :src="mainImagePreview" class="w-16 h-16 object-cover" />
                    <Input id="main_image" type="file" @change="handleMainImageUpload" />
                    <InputError :message="form.errors.main_image" />

                </div>


                <div class="grid gap-2">
                    <Label for="secondary_image">Zdjęcie dodatkowe</Label>
                    <img v-if="secondaryImagePreview" :src="secondaryImagePreview" class="w-16 h-16 object-cover" />
                    <Input id="secondary_image" type="file" @change="handleSecondaryImageUpload" />
                    <InputError :message="form.errors.secondary_image" />

                </div>


            </div>

            <div class="flex justify-between">
                <Button v-if="currentStep > 1" type="button" @click="currentStep--">Wstecz</Button>
                <Button v-if="currentStep < maxStep" type="button" @click="handleNextStep">Dalej</Button>
                <Button v-if="currentStep === maxStep" type="submit" :disabled="form.processing">
                    <LoaderCircle v-if="form.processing" class="h-4 w-4 animate-spin" />
                    Dodaj przepis
                </Button>
            </div>


        </form>
    </AuthBase>
    </AppLayout>
</template>
