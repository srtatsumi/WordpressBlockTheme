wp.blocks.registerBlockType("theme-blocks/banner",{
    title:"Pet Shop Banner",
    edit: EditComponent,
    save: SaveComponent
})

function EditComponent(){
    return (
        <>
        
        </>
    )
}
function SaveComponent(){
    return <p>THis is Demo</p>
}