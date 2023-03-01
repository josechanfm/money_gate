<template>
    <div class="min-h-screen flex flex-col sm:justify-center items-center bg-gray-100 p-4 ">

        <div class="w-full md:max-w-lg md:p-8 p-6 mt-36 md:mt-0 bg-white shadow-md  rounded-lg">
            
            <div class="mb-6 flex justify-center">
                <slot name="logo" />
            </div>
            <slot />
        </div>
    </div>
</template>
