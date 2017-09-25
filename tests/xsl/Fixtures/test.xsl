<?xml version="1.0" encoding="UTF-8"?>
<xsl:stylesheet version="1.0"
    xmlns:xsl="http://www.w3.org/1999/XSL/Transform">

<xsl:output method="xml" />
<xsl:template match="/class">

<class>
    <xsl:for-each select="student">
        <student>
            <xsl:value-of select="./first_name" /><xsl:text> </xsl:text><xsl:value-of select="./last_name" />
        </student>
    </xsl:for-each>


    <xsl:for-each select="teacher">
        <professor>
            <xsl:value-of select="./first_name" /><xsl:text> </xsl:text><xsl:value-of select="./last_name" />
        </professor>
    </xsl:for-each>
</class>

</xsl:template>

</xsl:stylesheet>