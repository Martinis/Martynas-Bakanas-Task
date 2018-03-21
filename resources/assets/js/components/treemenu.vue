<template>
  <ul>
  	<li>
    	<span v-on:click="deleteItem(id, name)">{{ name }}</span>
	    <tree-menu 
	      v-for="child in children" 
	      :children="child.children" 
	      :name="child.name"
	      :id="child.id"
	      :key="child.id"
	      :deleteItem="deleteItem"
	    >
	    </tree-menu>
	</li>
  </ul>
</template>
<script>
  export default { 
    props: ['id', 'name', 'children', 'deleteItem'],
    name: 'tree-menu'
  }
</script>