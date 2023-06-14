<template>
    <div>
        <!-- Если это корневой элемент компонента -->
        <template v-if="isRoot">
            <!-- Перечисляем корневые узлы -->
            <tree-view
                v-for="node in nodes"
                :key="node.id"
                :node="node"
                v-model="selectedId"
            > </tree-view>
        </template>
        <!-- Иначе, перечисляем дочерние узлы -->
        <template v-else-if="isNode">
            <div>
                <!-- Стрелка вверх / вниз -->
                <i
                    v-if="childrenExists"
                    class="fa"
                    :class="{'fa-angle-up': isOpen, 'fa-angle-down': !isOpen}"
                    :title="(isOpen ? 'Hide' : 'Show') + ' child nodes'"
                    @click="selectNode()"
                > </i>
                <!-- Имя узла -->
                <span
                    :class="{'tree-view__bold': isSelected}"
                    @click="selectNode()"
                >
                    {{ node.name }}
                </span>
            </div>
            <!-- Если вложенный блок открыт и есть дочерние узлы, перечисляем их -->
            <div v-show="isOpen" v-if="hasChildren">
                <tree-view
                    v-for="child in node.children"
                    :key="node.id"
                    :node="child"
                    v-model="selectedId"
                    ref="children"
                > </tree-view>
            </div>
        </template>
    </div>
</template>







<script>
    export default {
        name: "AppThree",

        /**
         * Set value to this.node.id and call this method in parent component
         *
         * @param {Number|Boolean|String} newValue
         */
        updateValue (newValue = null) {
            this.selectedId = arguments.length || !this.node ? newValue : this.node.id;
// If parent is TreeView node or root, set value to it
            if (this.$parent && (this.$parent.isNode || this.$parent.isRoot) && typeof this.$parent.updateValue === 'function') {
                this.$parent.updateValue(this.selectedId);
            }
            this.$emit('input', this.selectedId);
        }
    }
</script>

<style scoped>

</style>
