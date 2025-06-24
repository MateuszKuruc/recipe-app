<script setup lang="ts">
import InputError from '@/components/InputError.vue';
import TextLink from '@/components/TextLink.vue';
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
});

const submit = () => {
    form.post(route('register'), {
        onFinish: () => form.reset('password', 'password_confirmation'),
    });
};

const currentStep = ref(1);
const maxStep = 3;

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

const handleNextStep = () => {
    if (currentStep.value === 1) {
        if (validateStep1()) {
            currentStep.value++
        }
    } else if (currentStep.value === 2) {
        if (validateStep2()) {
            currentStep.value++
        }
    }
}
</script>

<template>
    <AppLayout>
    <AuthBase title="Dodaj nowy przepis" description="Uzupełnij wymagane pola i zapisz!">
        <Head title="Nowy przepis" />

        <form @submit.prevent="submit" class="flex flex-col gap-6">
            <div v-if="currentStep === 1" class="grid gap-6">

                <div class="grid gap-2">
                    <Label for="category">Kategoria</Label>
                    <select id="category" v-model="form.category_id" class="input w-full rounded border px-3 py-2">
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
                    <Input id="ingredients" type="text" required v-model="form.ingredients" placeholder="email@example.com" />
                    <InputError :message="form.errors.ingredients" />
                </div>


                <div class="grid gap-2">
                    <Label for="prepare_time">Czas przygotowania</Label>
                    <Input id="prepare_time" type="text" required v-model="form.prepare_time" placeholder="email@example.com" />
                    <InputError :message="form.errors.prepare_time" />
                </div>

                <div class="grid gap-2">
                    <Label for="cooking_time">Czas gotowania</Label>
                    <Input id="cooking_time" type="text" required v-model="form.email" placeholder="email@example.com" />
                    <InputError :message="form.errors.email" />
                </div>

                <div class="grid gap-2">
                    <Label for="servings">Liczba porcji</Label>
                    <Input id="servings" type="text" required v-model="form.email" placeholder="email@example.com" />
                    <InputError :message="form.errors.email" />
                </div>

                    </div>
            <div v-if="currentStep === 3" class="grid gap-6">

                    <div class="grid gap-2">
                        <Label for="excerpt">Instrukcja</Label>
                        <Input id="excerpt" type="text" required v-model="form.email" placeholder="email@example.com" />
                        <InputError :message="form.errors.email" />
                    </div>

                <div class="grid gap-2">
                    <Label for="main_image">Zdjęcie główne</Label>
                    <Input id="main_image" type="text" required v-model="form.email" placeholder="email@example.com" />
                    <InputError :message="form.errors.email" />
                </div>

                <div class="grid gap-2">
                    <Label for="secondary_image">Zdjęcie dodatkowe</Label>
                    <Input id="secondary_image" type="text" required v-model="form.email" placeholder="email@example.com" />
                    <InputError :message="form.errors.email" />
                </div>



<!--                <Button type="submit" class="mt-2 w-full" tabindex="5" :disabled="form.processing">-->
<!--                    <LoaderCircle v-if="form.processing" class="h-4 w-4 animate-spin" />-->
<!--                    Create account-->
<!--                </Button>-->
            </div>

            <div class="flex justify-between">
                <Button v-if="currentStep > 1" type="button" @click="currentStep--">Previous</Button>
                <Button v-if="currentStep < maxStep" type="button" @click="handleNextStep">Next</Button>
                <Button v-if="currentStep === maxStep" type="submit" :disabled="form.processing">
                    <LoaderCircle v-if="form.processing" class="h-4 w-4 animate-spin" />
                    Submit
                </Button>
            </div>


        </form>
    </AuthBase>
    </AppLayout>
</template>
