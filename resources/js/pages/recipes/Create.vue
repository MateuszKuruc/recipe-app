<script setup lang="ts">
import InputError from '@/components/InputError.vue';
import { Button } from '@/components/ui/button';
import { Input } from '@/components/ui/input';
import { Label } from '@/components/ui/label';
import AuthBase from '@/layouts/AuthLayout.vue';
import { Head, useForm } from '@inertiajs/vue3';
import { LoaderCircle } from 'lucide-vue-next';
import { computed } from 'vue';
import AppLayout from '@/layouts/AppLayout.vue';
import { ref } from 'vue';
import {
    Select,
    SelectContent,
    SelectGroup,
    SelectItem,
    SelectLabel,
    SelectTrigger,
    SelectValue,
} from '@/components/ui/select'
import { Textarea } from '@/components/ui/textarea'


defineProps({
    categories: Array,
    tags: Array
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
    tags: []
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

// const selectedTags = ref([]);

</script>

<template>
    <AppLayout>
    <AuthBase title="Dodaj nowy przepis" description="Uzupełnij wymagane pola i zapisz swój przepis!">
        <Head title="Nowy przepis" />

        <form @submit.prevent="submit" class="flex flex-col gap-6">
            <div v-if="currentStep === 1" class="grid gap-6">

                <div>
                    <h2 class="font-semibold mb-2">Tagi</h2>

                    <div class="flex flex-col gap-2">
                        <div
                            v-for="tag in tags"
                            :key="tag.id"
                            class="flex items-center gap-2"
                        >
                            <input
                                type="checkbox"
                                :id="`tag-${tag.id}`"
                                :value="tag.id"
                                v-model="form.tags"
                            />
                            <label :for="`tag-${tag.id}`">{{ tag.name }}</label>
                        </div>
                    </div>
                </div>

                <div class="grid gap-2">
                    <Label for="category">Kategoria</Label>

                    <Select v-model="form.category_id">
                        <SelectTrigger class="w-full">
                            <SelectValue placeholder="Wybierz kategorię" />
                        </SelectTrigger>
                        <SelectContent>
                            <SelectItem
                                v-for="category in categories"
                                :key="category.id"
                                :value="String(category.id)"
                            >
                                {{ category.name }}
                            </SelectItem>
                        </SelectContent>
                    </Select>

                    <InputError :message="form.errors.category_id" />
                </div>


                <div class="grid gap-2">
                    <Label for="title">Nazwa</Label>
                    <Input id="title" type="text" required v-model="form.title" placeholder="Pizza" />
                    <InputError :message="form.errors.title" />
                </div>

                <div class="grid gap-2">
                    <Label for="excerpt">Krótki opis</Label>

                    <Textarea
                        id="excerpt"
                        v-model="form.excerpt"
                        placeholder="Napisz kilka słów o przepisie"
                        class="h-24"
                    />

                    <InputError :message="form.errors.excerpt" />
                </div>

            </div>
                <div v-if="currentStep === 2" class="grid gap-6">



                    <div class="grid gap-2">
                        <Label for="excerpt">Składniki</Label>

                        <Textarea
                            id="ingredients"
                            v-model="form.ingredients"
                            placeholder="300g kurczaka, 2 papryki..."
                            class="h-24"
                        />

                        <InputError :message="form.errors.ingredients" />
                    </div>


                    <div class="grid gap-2">
                        <Label for="prepare_time">Czas przygotowania</Label>

                        <Select v-model="form.prepare_time">
                            <SelectTrigger class="w-full">
                                <SelectValue placeholder="Wybierz wartość" />
                            </SelectTrigger>
                            <SelectContent>
                                <SelectItem value="0">0 min</SelectItem>
                                <SelectItem value="5">5 min</SelectItem>
                                <SelectItem value="15">15 min</SelectItem>
                                <SelectItem value="30">30 min</SelectItem>
                                <SelectItem value="45">45 min</SelectItem>
                                <SelectItem value="60">1 godz.</SelectItem>
                                <SelectItem value="90">1 godz. 30 min</SelectItem>
                                <SelectItem value="120">ponad 2 godz.</SelectItem>
                            </SelectContent>
                        </Select>

                        <InputError :message="form.errors.prepare_time" />
                    </div>

                    <div class="grid gap-2">
                        <Label for="cooking_time">Czas gotowania</Label>

                        <Select v-model="form.cooking_time">
                            <SelectTrigger class="w-full">
                                <SelectValue placeholder="Wybierz wartość" />
                            </SelectTrigger>
                            <SelectContent>
                                <SelectItem value="0">0 min</SelectItem>
                                <SelectItem value="5">5 min</SelectItem>
                                <SelectItem value="15">15 min</SelectItem>
                                <SelectItem value="30">30 min</SelectItem>
                                <SelectItem value="45">45 min</SelectItem>
                                <SelectItem value="60">1 godz.</SelectItem>
                                <SelectItem value="75">1 godz. 15 min</SelectItem>
                                <SelectItem value="90">1 godz. 30 min</SelectItem>
                                <SelectItem value="120">ponad 2 godz.</SelectItem>
                            </SelectContent>
                        </Select>

                        <InputError :message="form.errors.cooking_time" />
                    </div>

                    <div class="grid gap-2">
                        <Label for="servings">Liczba porcji</Label>

                        <Select v-model="form.servings">
                            <SelectTrigger class="w-full">
                                <SelectValue placeholder="Wybierz wartość" />
                            </SelectTrigger>
                            <SelectContent>
                                <SelectItem value="1">dla 1 osoby</SelectItem>
                                <SelectItem value="2">dla 2 osób</SelectItem>
                                <SelectItem value="3">dla 3 osób</SelectItem>
                                <SelectItem value="4">dla 4 osób</SelectItem>
                                <SelectItem value="5">dla 5 osób</SelectItem>
                                <SelectItem value="6">dla 6 osób</SelectItem>
                            </SelectContent>
                        </Select>

                        <InputError :message="form.errors.servings" />
                    </div>


                    </div>
            <div v-if="currentStep === 3" class="grid gap-6">



                <div class="grid gap-2">
                <Textarea
                    id="instructions"
                    v-model="form.instructions"
                    placeholder="Opisz wszystkie kroki"
                    class="h-24"
                />
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
